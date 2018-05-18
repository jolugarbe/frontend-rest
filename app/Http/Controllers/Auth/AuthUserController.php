<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthUserController extends Controller
{
    protected $userRepo;

    function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    protected function postRegister(Request $request){
        $result = $this->userRepo->register($request->all());

        if($result['status'] == 200){
            return redirect('login')->with('success', 'User registered successfully.');
        }else{
            return redirect()->back()->withInput()->with('error', 'An error occurred while trying to register the user.');
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
