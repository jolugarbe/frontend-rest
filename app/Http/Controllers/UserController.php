<?php

namespace App\Http\Controllers;

use App\Repositories\ActivityRepo;
use App\Repositories\LocalityRepo;
use App\Repositories\ProvinceRepo;
use App\Repositories\UserRepo;
use App\Repositories\WasteRepo;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userRepo;
    protected $activityRepo;
    protected $localityRepo;
    protected $provinceRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo, ActivityRepo $activityRepo, LocalityRepo $localityRepo, ProvinceRepo $provinceRepo)
    {
        $this->middleware('cookie');
        $this->userRepo = $userRepo;
        $this->activityRepo = $activityRepo;
        $this->localityRepo = $localityRepo;
        $this->provinceRepo = $provinceRepo;
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

                return view('site.users.show-profile', compact('user', 'activity', 'address', 'locality', 'province', 'notification', 'not_address', 'not_locality', 'not_province'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('ERROR SHOW ENTERPRISE: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la empresa. Disculpe las molestias.');
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

                return view('site.users.profile', compact('user', 'address', 'not_address', 'province_id', 'not_province_id', 'notification', 'activities', 'provinces', 'localities'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar tu perfil. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('ERROR PROFILE: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar tu perfil. Disculpe las molestias.');
        }

    }

    protected function postUpdate(Request $request){

        try{
            $result = $this->userRepo->update($request->all());

            if($result['status'] == 200){
                return redirect()->back()->withInput()->with('success', 'Datos actualizados correctamente.');
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar su empresa. Disculpe las molestias.');
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
