<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;


use App\User;

class UserRepo extends GuzzleHttpRequest
{

    public function getModel()
    {
        return new User();
    }

    public function register($data)
    {
        $response = $this->post('register', $data);
        return $response;
    }

    public function login($data)
    {
        $response = $this->post('login', $data);
        return $response;
    }

    public function logout(){

        $response = $this->post('user/logout', false);
        return $response;
    }

    public function profile(){
        $response = $this->post('user/profile', false);
        return $response;
    }
}