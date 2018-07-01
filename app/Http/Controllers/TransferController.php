<?php

namespace App\Http\Controllers;

use App\Jobs\EnviarMail;
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

            $waste = $content['waste'];
            $owner_email = $content['owner_email'];
            try {

                // Send to the new owner of the waste
                $contenido = \View::make('emails.accept-transfer', compact('waste'))->render();
                $datos = [
                    $owner_email,
                    $owner_email,
                    'info@cafa.nelium.net',
                    'CAFA',
                    'Solicitud aceptada',
                    $contenido,
                    null,
                    null];

                $mail = new EnviarMail($datos);
                $this->dispatch($mail);
            }catch (\Exception $exception){
                return array('result' => 'warning', 'message' => 'Solicitud aceptada correctamente. Se ha producido un error al enviar el email de notificación.');
            }

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

            $waste = $content['waste'];
            $owner_email = $content['owner_email'];
            try {

                // Send to the owner of the waste
                $contenido = \View::make('emails.decline-transfer', compact('waste'))->render();
                $datos=[
                    $owner_email,
                    $owner_email,
                    'info@cafa.nelium.net',
                    'CAFA',
                    'Solicitud rechazada',
                    $contenido,
                    null,
                    null];

                $mail=new EnviarMail($datos);
                $this->dispatch($mail);

            }catch (\Exception $exception){
                return array('result' => 'warning', 'message' => 'Solicitud rechazada correctamente. Se ha producido un error al enviar el email de notificación.');
            }

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

            $waste = $content['waste'];
            $creator_email = $content['creator_email'];
            try {

                // Send to the owner of the waste
                $contenido = \View::make('emails.cancel-transfer', compact('waste'))->render();
                $datos=[
                    $creator_email,
                    $creator_email,
                    'info@cafa.nelium.net',
                    'CAFA',
                    'Solicitud cancelada',
                    $contenido,
                    null,
                    null];

                $mail=new EnviarMail($datos);
                $this->dispatch($mail);

            }catch (\Exception $exception){
                return array('result' => 'warning', 'message' => 'Solicitud cancelada correctamente. Se ha producido un error al enviar el email de notificación.');
            }

            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al procesar la cancelación de la solicitud.');
        }
    }

}
