<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

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

        try{
            $result = $this->userRepo->login($request->all());

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                // Create a cookie and send to the browser
                $token = cookie('user_token', $content['token']);

                if($content['role_admin']){
                    $admin = cookie('user_admin', true);
                    return redirect()->to('admin/dashboard')->withCookie($token)->withCookie($admin);
                }else{
                    return redirect()->to('home')->withCookie($token);
                }

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar iniciar sesión. Disculpe las molestias.');
            }

        }catch (ClientException $exception){

            // Get the errors from the backend validation and return to the view.
            $response = $exception->getResponse();
            if($response->getStatusCode() == 401){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->withInput()->with('error', 'No ha sido posible iniciar sesión por los siguientes motivos:')->with('validation_errors', $content['error']);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al iniciar sesión. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al iniciar sesión. Disculpe las molestias.');
        }

    }

    public function postLogout(Request $request){

        $result = $this->userRepo->logout();
        return redirect('/')->withCookie(Cookie::forget('user_token'))->withCookie(Cookie::forget('user_admin'));
    }

    public function postUserEmailReset(Request $request){
        try{
            $result = $this->userRepo->emailResetPass($request->all());
            $content = json_decode(json_encode($result['body']), true);
            return redirect('login')->with('success', $content['success']);
        }catch (\Exception $exception){
            $response = $exception->getResponse();
            $content = json_decode($response->getBody()->getContents(), true);
            return redirect()->back()->withInput()->with('error', $content['error']);
        }
    }


    public function getTokenPasswordReset($token){
        try{
            $result = $this->userRepo->checkTokenResetPass(array('token_reset_pass' => $token));
            $content = json_decode(json_encode($result['body']), true);
            $email = $content['email'];
            return view('auth.passwords.reset', compact('email', 'token'));
        }catch (\Exception $exception){
            $response = $exception->getResponse();
            $content = json_decode($response->getBody()->getContents(), true);
            return redirect('login')->with('error', $content['error']);
        }
    }

    public function postUserPasswordReset(Request $request){
        try{
            $result = $this->userRepo->setNewPassword($request->all());
            $content = json_decode(json_encode($result['body']), true);
            return redirect('login')->with('success', $content['message']);
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible actualizar su contraseña por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->withInput()->with('error', $content['message']);
            }
        }catch (\Exception $exception){
            $response = $exception->getResponse();
            $content = json_decode($response->getBody()->getContents(), true);
            return redirect()->back()->withInput()->with('error', $content['message']);
        }

    }
}
