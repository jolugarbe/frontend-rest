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

    public function profileHome(){
        $response = $this->post('user/profile-home', false);
        return $response;
    }

    public function profileData(){
        $response = $this->post('user/profile-data', false);
        return $response;
    }

    public function userDataForShow($data)
    {
        $response = $this->post('user/show', $data);
        return $response;
    }

    public function update($data)
    {
        $response = $this->post('user/update', $data);
        return $response;
    }
}