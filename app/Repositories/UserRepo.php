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

    public function updatePassword($data)
    {
        $response = $this->post('user/password/update', $data);
        return $response;
    }

    public function emailResetPass($data)
    {
        $response = $this->post('email-reset', $data);
        return $response;
    }

    public function checkTokenResetPass($data)
    {
        $response = $this->post('reset-pass/check-token', $data);
        return $response;
    }

    public function setNewPassword($data)
    {
        $response = $this->post('reset-pass/update-password', $data);
        return $response;
    }


    // ADMIN
    public function adminDashboard()
    {
        $response = $this->post('admin/dashboard-data', false);
        return $response;
    }

    public function usersList($data)
    {
        $response = $this->post('admin/users/list-data', $data);
        return $response;
    }

    public function userDataForCreate()
    {
        $response = $this->get('users/create-data');
        return $response;
    }

    public function userData($data)
    {
        $response = $this->post('admin/users/user-data', $data);
        return $response;
    }

    public function updateFromAdmin($data)
    {
        $response = $this->post('admin/users/update', $data);
        return $response;
    }

    public function deleteUser($data)
    {
        $response = $this->post('admin/users/delete', $data);
        return $response;
    }

    public function updateAdmin($data)
    {
        $response = $this->post('admin/profile/update', $data);
        return $response;
    }
}