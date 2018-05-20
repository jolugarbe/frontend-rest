<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;

class AuthUserController extends Controller
{
    protected $userRepo;

    function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    protected function postRegister(Request $request){

        try{
            $result = $this->userRepo->register($request->all());

            if($result['status'] == 200){
                return redirect('login')->with('success', 'Empresa registrada correctamente. Hemos enviado los datos de acceso a su email.');
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible registrar su empresa por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar su empresa. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar su empresa. Disculpe las molestias.');
        }

    }

    public function postLogin(Request $request){

        $result = $this->userRepo->login($request->all());

        if($result['status'] == 200){
            // Convert body std object to array
            $content = json_decode(json_encode($result['body']), true);
            // Create a cookie and send to the browser
            $cookie = cookie('frontendToken', $content['token'], 525600);


            return redirect()->to('home')->with('success', 'Welcome to Frontend.local')->withCookie($cookie);
        }else{
            return redirect()->back()->with('error', 'An error occurred while trying to login the user.');
        }
    }
}
