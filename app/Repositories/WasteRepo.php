<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;



class WasteRepo extends GuzzleHttpRequest
{

    public function wasteDataForCreate()
    {
        $data = $this->get('waste/create-data');
        return $data;
    }

    public function register($data){
        $response = $this->post('waste/register', $data);
        return $response;
    }
//    public function all()
//    {
//        $provinces = $this->get('provinces/all');
//        return $provinces;
//    }

}