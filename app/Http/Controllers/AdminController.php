<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarMail;
use App\Repositories\ActivityRepo;
use App\Repositories\UserRepo;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{

    protected $userRepo;
    protected $activityRepo;

    function __construct(UserRepo $userRepo, ActivityRepo $activityRepo)
    {
        $this->userRepo = $userRepo;
        $this->activityRepo = $activityRepo;
    }

    public function dashboard()
    {
        $result = $this->userRepo->adminDashboard();
        $result = json_decode(json_encode($result['body']), true);
        $user = $result['user'];
        $total_users = $result['total_users'];
        $total_transfers = $result['total_transfers'];
        $total_demand = $result['total_demand'];
        $total_offers = $result['total_offers'];
        return view('admin.dashboard', compact('total_offers', 'total_demand', 'total_users', 'total_transfers'));
    }

    public function getUsersList()
    {
        $result = $this->activityRepo->all();
        $result = json_decode(json_encode($result['body']), true);
        $activities = $result['activities'];

        return view('admin.users.users-list', compact('activities'));
    }

    public function postUsersListData(Request $request){
        $response = $this->userRepo->usersList($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('carbon_footprint', function ($user) {
                if($user->carbon_footprint)
                    return "SÍ";
                else
                    return "NO";
            })
            ->editColumn('register_date', function ($user) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $user->register_date)->format('d/m/Y');
            })
            ->editColumn('carbon_inscription', function ($user) {
                if($user->carbon_inscription)
                    return Carbon::createFromFormat('Y-m-d', $user->carbon_inscription)->format('d/m/Y');
                else
                    return "-";
            })
            ->editColumn('cif', function ($user) {
                if(!$user->cif)
                    return "-";
                else
                    return $user->cif;
            })
            ->addColumn('action', function ($user) {
                $url_show_user = URL::to('admin/users/show/'.$user->id);
                $url_edit_user = URL::to('admin/users/update/'.$user->id);

                $links = '';


//                $links .= '<a href="'.$url_show_user.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver usuario"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_edit_user.'" class="btn btn-primary m-1" data-toggle="tooltip" data-placement="top" title="Editar usuario"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

                $links .= '<a data-user_id="'.$user->id.'" class="delete-user btn btn-danger m-1 text-white"  data-toggle="tooltip" data-placement="top" title="Eliminar usuario"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'carbon_footprint', 'register_date', 'carbon_inscription'])
            ->make(true);
    }

    public function createUser()
    {
        $result = $this->userRepo->userDataForCreate();
        $result = json_decode(json_encode($result['body']), true);
        $activities = $result['activities'];
        $provinces = $result['provinces'];
        $localities = $result['localities'];

        return view('admin.users.create-edit-user', compact('activities', 'provinces', 'localities'));
    }

    public function postUserCreate(Request $request)
    {
        try{
            $result = $this->userRepo->register($request->all());

            $email = $request->input('email');
            $password = $request->input('password');

            if($result['status'] == 200){

                $contenido = \View::make('emails.user-welcome',  compact('password', 'email'))->render();
                $datos=[
                    $email,
                    $email,
                    'info@cafa.nelium.net',
                    'CAFA',
                    'CAFA | Datos de Acceso a la Bolsa de Residuos Reutilizables y Reciclables',
                    $contenido,
                    null,
                    null];

                $mail=new EnviarMail($datos);
                $this->dispatch($mail);

                return redirect('admin/users/list')->with('success', 'Empresa registrada correctamente. Hemos enviado los datos de acceso al email registrado.');
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar la empresa.');
            }
        }catch (ClientException $exception){

            // Get the errors from the backend validation and return to the view.
            $response = $exception->getResponse();
            if($response->getStatusCode() == 422){
                $errors = array();
                foreach (json_decode($response->getBody()->getContents(), true) as $items){
                    foreach ($items as $item){
                        array_push($errors, $item[0]);
                    }
                }
                return redirect()->back()->withInput()->with('error', 'No ha sido posible registrar la empresa por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar la empresa.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar la empresa.');
        }
    }

    public function updateUser($user_id)
    {
        try{

            $result = $this->userRepo->userData(array('user_id' => $user_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);

                $user = $content['user'];

                $address = $content['address'];
                $province_id = $content['province_id'];
                $not_province_id = $content['not_province_id'];

                $notification = $content['notification'];
                $not_address = $content['not_address'];
                $activities = $content['activities'];
                $provinces = $content['provinces'];
                $localities = $content['localities'];

                return view('admin.users.create-edit-user', compact('user', 'address', 'not_address', 'province_id', 'not_province_id', 'notification', 'activities', 'provinces', 'localities'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el usuario.');
            }
        }catch (\Exception $exception){

            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el usuario.');
        }
    }


    public function postUserUpdate(Request $request)
    {
        try{
            $result = $this->userRepo->updateFromAdmin($request->all());

            $email = $request->input('email');
            $password = $request->input('password');

            if($result['status'] == 200){

//                $contenido = \View::make('emails.user-welcome',  compact('password', 'email'))->render();
//                $datos=[
//                    $email,
//                    $email,
//                    'info@cafa.nelium.net',
//                    'CAFA',
//                    'CAFA | Datos de Acceso a la Bolsa de Residuos Reutilizables y Reciclables',
//                    $contenido,
//                    null,
//                    null];
//
//                $mail=new EnviarMail($datos);
//                $this->dispatch($mail);

                return redirect('admin/users/list')->with('success', 'Empresa actualizada correctamente.');
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar la empresa.');
            }
        }catch (ClientException $exception){

            // Get the errors from the backend validation and return to the view.
            $response = $exception->getResponse();
            if($response->getStatusCode() == 422){
                $errors = array();
                foreach (json_decode($response->getBody()->getContents(), true) as $items){
                    foreach ($items as $item){
                        array_push($errors, $item[0]);
                    }
                }
                return redirect()->back()->withInput()->with('error', 'No ha sido posible actualizar la empresa por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar la empresa.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar la empresa.');
        }
    }

    public function postUserDelete(Request $request){
        try{
            $response = $this->userRepo->deleteUser($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al eliminar el usuario.');
        }

    }
}
