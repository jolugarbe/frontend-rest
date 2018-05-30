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

    public function wasteDataForUpdate($data)
    {
        $response = $this->post('waste/update-data', $data);
        return $response;
    }

    public function register($data){
        $response = $this->post('waste/register', $data);
        return $response;
    }

    public function update($data){
        $response = $this->post('waste/update', $data);
        return $response;
    }
//    public function all()
//    {
//        $provinces = $this->get('provinces/all');
//        return $provinces;
//    }

    public function userOffersWasteData($data){
        $response = $this->post('waste/user/offers-data', $data);
        return $response;
    }

    public function availableListData($data){
        $response = $this->post('waste/list/available-data', $data);
        return $response;
    }

    public function wasteById($data){
        $response = $this->post('waste/data-by-id', $data);
        return $response;
    }

    public function userTransfersWasteData($data){
        $response = $this->post('waste/user/transfers-data', $data);
        return $response;
    }

    public function userRequestsWasteData($data){
        $response = $this->post('waste/user/requests-data', $data);
        return $response;
    }

    public function requestWaste($data){
        $response = $this->post('waste/request-waste', $data);
        return $response;
    }

    public function wasteDataForShow($data)
    {
        $response = $this->post('waste/show', $data);
        return $response;
    }

    public function deleteWaste($data){
        $response = $this->post('waste/delete', $data);
        return $response;
    }

}