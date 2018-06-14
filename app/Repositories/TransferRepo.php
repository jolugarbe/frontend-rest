<?php
/**
 * Created by PhpStorm.
 * User: USUARIO
 * Date: 05/05/2018
 * Time: 12:36
 */

namespace App\Repositories;



class TransferRepo extends GuzzleHttpRequest
{
    public function acceptTransfer($data){
        $response = $this->post('transfer/accept', $data);
        return $response;
    }

    public function declineTransfer($data){
        $response = $this->post('transfer/decline', $data);
        return $response;
    }

    public function cancelTransfer($data){
        $response = $this->post('transfer/cancel', $data);
        return $response;
    }
}