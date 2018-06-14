<?php

namespace App\Http\Controllers;

use App\Repositories\TransferRepo;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    protected $transferRepo;

    function __construct(TransferRepo $transferRepo)
    {
        $this->transferRepo = $transferRepo;
    }


    public function postAcceptTransfer(Request $request){
        try{
            $response = $this->transferRepo->acceptTransfer($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al procesar la aceptación de la solicitud.');
        }
    }

    public function postDeclineTransfer(Request $request){
        try{
            $response = $this->transferRepo->declineTransfer($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al procesar el rechazo de la solicitud.');
        }
    }

    public function postCancelTransfer(Request $request){
        try{
            $response = $this->transferRepo->cancelTransfer($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al procesar la cancelación de la solicitud.');
        }
    }

}
