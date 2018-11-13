<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarMail;
use App\Repositories\ActivityRepo;
use App\Repositories\TransferRepo;
use App\Repositories\UserRepo;
use App\Repositories\WasteRepo;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class AdminController extends Controller
{

    protected $userRepo;
    protected $activityRepo;
    protected $wasteRepo;
    protected $transferRepo;

    function __construct(UserRepo $userRepo, ActivityRepo $activityRepo, WasteRepo $wasteRepo, TransferRepo $transferRepo)
    {
        $this->userRepo = $userRepo;
        $this->activityRepo = $activityRepo;
        $this->wasteRepo = $wasteRepo;
        $this->transferRepo = $transferRepo;
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
        $users_months = $result['users_months'];
        $transfers_months = $result['transfers_months'];
        $waste_available_months = $result['waste_available_months'];
        $waste_request_months = $result['waste_request_months'];
        return view('admin.dashboard', compact('total_offers', 'total_demand', 'total_users', 'total_transfers', 'users_months', 'transfers_months', 'waste_available_months', 'waste_request_months'));
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
                    'admin@bolsacafa.com',
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

    public function getWasteAvailableList(){
        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $cer_subgroups = $content['cer_subgroups'];
                $cer_codes = $content['cer_codes'];
                return view('admin.waste.waste-available-list', compact('ads', 'types', 'cer_subgroups', 'cer_codes'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }

    }

    public function postWasteAvailableData(Request $request){
        $response = $this->wasteRepo->availableListData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('admin/users/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $link;
            })
            ->editColumn('pickup_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
            })
//            ->editColumn('generation_date', function ($waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->generation_date)->format('d/m/Y');
//            })
            ->editColumn('publication_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $waste->publication_date)->format('d/m/Y');
            })
            ->editColumn('dangerous', function ($waste) {
                return $waste->dangerous == 1 ? "SÍ" : "NO";
            })
            ->addColumn('action', function ($waste) {
                $url_edit_waste = URL::to('admin/waste/edit/'.$waste->id);
                $url_show_waste = URL::to('admin/waste/show/'.$waste->id);
                $links = '';
                $links .= '<a href="'.$url_show_waste.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver residuo"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_edit_waste.'" class="btn btn-success request-waste text-white" data-waste_id="'.$waste->id.'" data-toggle="tooltip" data-placement="top" title="Editar residuo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

                $links .= '<a data-waste_id="'.$waste->id.'" class="delete-waste btn btn-danger m-1 text-white"  data-toggle="tooltip" data-placement="top" title="Eliminar residuo"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'creator_name'])
            ->make(true);
    }

    public function getShowUser($user_id){
        try{

            $result = $this->userRepo->userDataForShow(array('user_id' => $user_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);

                $user = $content['user'];
                $activity = $content['activity'];

                $address = $content['address'];
                $locality = $content['locality'];
                $province = $content['province'];

                $notification = $content['notification'];
                $not_address = $content['not_address'];
                $not_locality = $content['not_locality'];
                $not_province = $content['not_province'];

                return view('admin.users.show-profile', compact('user', 'activity', 'address', 'locality', 'province', 'notification', 'not_address', 'not_locality', 'not_province'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la empresa. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('ERROR SHOW ENTERPRISE: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la empresa. Disculpe las molestias.');
        }

    }

    public function getShowWaste($waste_id){
        try{
            $result = $this->wasteRepo->wasteDataForShow(array('waste_id' => $waste_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $cer_code = $content['cer_code'];
                $show = true;

                // Compruebo que el residuo sea del usuario
                return view('admin.waste/show-waste', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'show', 'cer_code'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');

        }

    }


    public function getEditWaste($waste_id){
        try{
            $result = $this->wasteRepo->wasteDataForUpdate(array('waste_id' => $waste_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $frequencies = $content['frequencies'];
                $provinces = $content['provinces'];
                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $cer_subgroups = $content['cer_subgroups'];
                $cer_codes = $content['cer_codes'];

                // Compruebo que el residuo sea del usuario
                return view('admin.waste/create-edit-waste', compact('ads', 'types', 'frequencies', 'provinces', 'localities', 'waste', 'address', 'locality', 'cer_subgroups', 'cer_codes'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');

        }

    }

    public function postUpdateWaste(Request $request){
        try{
            $result = $this->wasteRepo->update($request->all());

            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                return redirect('admin/dashboard')->with('success', $content['message']);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible actualizar el residuo por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
        }
    }

    public function getWasteDemandList(){
        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $cer_subgroups = $content['cer_subgroups'];
                $cer_codes = $content['cer_codes'];
                return view('admin/waste.waste-demand-list', compact('ads', 'types', 'cer_subgroups', 'cer_codes'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }

    }

    public function postWasteDemandData(Request $request){
        $response = $this->wasteRepo->demandListData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('admin/user/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $link;
            })
//            ->editColumn('pickup_date', function (Waste $waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
//            })
//            ->editColumn('generation_date', function (Waste $waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->generation_date)->format('d/m/Y');
//            })
            ->editColumn('publication_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $waste->publication_date)->format('d/m/Y');
            })
            ->editColumn('dangerous', function ($waste) {
                return $waste->dangerous == 1 ? "SÍ" : "NO";
            })
            ->addColumn('action', function ($waste) {
                $url_edit_waste = URL::to('admin/waste/edit/'.$waste->id);
                $url_show_waste = URL::to('admin/waste/show/'.$waste->id);
                $links = '';
                $links .= '<a href="'.$url_show_waste.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver residuo"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_edit_waste.'" class="btn btn-success request-waste text-white" data-waste_id="'.$waste->id.'" data-toggle="tooltip" data-placement="top" title="Editar residuo"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

                $links .= '<a data-waste_id="'.$waste->id.'" class="delete-waste btn btn-danger m-1 text-white"  data-toggle="tooltip" data-placement="top" title="Eliminar residuo"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                return $links;
            })
            ->rawColumns(['action', 'creator_name'])
            ->make(true);
    }

    public function getTransfersRequestList()
    {
        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $cer_subgroups = $content['cer_subgroups'];
                $cer_codes = $content['cer_codes'];
                return view('admin.waste.request-transfer-list', compact('ads', 'types', 'cer_subgroups', 'cer_codes'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar las solicitudes. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar las solicitudes. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar las solicitudes. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar las solicitudes. Disculpe las molestias.');
        }
    }

    public function postTransfersData(Request $request)
    {
        $response = $this->wasteRepo->allTransfersWasteData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('name', function ($waste) {
                $url = URL::to('admin/waste/show/'.$waste->id);
                $name = '<a href="'.$url.'" target="_blank">'.$waste->name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $name;
            })
            ->editColumn('request_name', function ($waste) {
                $url = URL::to('admin/users/show/'.$waste->request_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->request_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';

                return $link;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('admin/users/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';

                return $link;
            })
            ->editColumn('status', function ($waste) {
                $type = '';
                if ($waste->status_id == 1)
                    $type .= '<span class="badge badge-yellow" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 2)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 3)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 4)
                    $type .= '<span class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';

                return $type;
            })
//            ->editColumn('quantity', function ($waste) {
//                $quantity = $waste->quantity . " " . $waste->measured_unit;
//                return $quantity;
//            })
//            ->editColumn('pickup_date', function ($waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
//            })
            ->editColumn('request_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->request_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($waste) {

                $url_show_transfer = URL::to('admin/waste/show-transfer/'.$waste->transfer_id);
                $url_show_transfer_pdf = URL::to('waste/user/show-transfer/pdf/'.$waste->transfer_id);

                $links = '';

                $links .= '<a href="'.$url_show_transfer.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver solicitud"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_show_transfer_pdf.'" class="btn btn-purple m-1" data-toggle="tooltip" data-placement="top" title="Descargar solicitud"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>';
                $links .= '<a class="btn btn-danger delete-transfer m-1 text-white" data-transfer_id="'.$waste->transfer_id.'" data-toggle="tooltip" data-placement="top" title="Eliminar solicitud"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'status', 'name', 'request_name', 'creator_name'])
            ->make(true);
    }

    public function getShowTransfer($transfer_id){
        try{
            $result = $this->wasteRepo->wasteTransferRequestDataForShow(array('transfer_id' => $transfer_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $cer_code = $content['cer_code'];
                $address = $content['address'];
                $locality = $content['locality'];
                $is_transfer = true;

                $owner_user = $content['owner_user'];
                $owner_activity = $content['owner_activity'];
                $owner_address = $content['owner_address'];
                $owner_locality = $content['owner_locality'];
                $owner_province = $content['owner_province'];

                $request_user = $content['request_user'];
                $request_activity = $content['request_activity'];
                $request_address = $content['request_address'];
                $request_locality = $content['request_locality'];
                $request_province = $content['request_province'];

                $status_transfer_id = $content['status_transfer_id'];
                $status_transfer_name = $content['status_transfer_name'];

                // Compruebo que el residuo sea del usuario
                return view('admin.waste/show-transfer-request', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_transfer', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id', 'status_transfer_id', 'status_transfer_name', 'cer_code'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('VER CESIÓN: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');

        }
    }

    public function postDeleteTransfer(Request $request){
        try{
            $response = $this->transferRepo->deleteTransfer($request->all());
            $content = json_decode(json_encode($response['body']), true);

            $waste = $content['waste'];
            $creator_email = $content['creator_email'];
            $request_email = $content['request_email'];
//            try {
//
//                // Send to the owner of the waste
//                $contenido = \View::make('emails.cancel-transfer', compact('waste'))->render();
//                $datos=[
//                    $creator_email,
//                    $creator_email,
//                    'info@cafa.nelium.net',
//                    'CAFA',
//                    'Solicitud cancelada',
//                    $contenido,
//                    null,
//                    null];
//
//                $mail=new EnviarMail($datos);
//                $this->dispatch($mail);
//
//            }catch (\Exception $exception){
//                return array('result' => 'warning', 'message' => 'Solicitud cancelada correctamente. Se ha producido un error al enviar el email de notificación.');
//            }

            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al intentar eliminar la solicitud.');
        }
    }

    public function getProfile(){

        try{

            $result = $this->userRepo->profileData();
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

                return view('admin.profile', compact('user', 'address', 'not_address', 'province_id', 'not_province_id', 'notification', 'activities', 'provinces', 'localities'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar acceder a tu perfil. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('ERROR PROFILE: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar acceder a tu perfil. Disculpe las molestias.');
        }

    }

    protected function postUpdateProfile(Request $request){

        try{
            $result = $this->userRepo->updateAdmin($request->all());

            if($result['status'] == 200){
                return redirect()->back()->withInput()->with('success', 'Datos actualizados correctamente.');
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al sus datos. Disculpe las molestias.');
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible actualizar los datos por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar sus datos. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('USER UPDATE ERROR: '.$exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar sus datos. Disculpe las molestias.');
        }

    }
}
