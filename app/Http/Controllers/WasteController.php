<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use App\Repositories\WasteRepo;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Barryvdh\Snappy\Facades\SnappyPdf;

class WasteController extends Controller
{
    protected $userRepo;
    protected $wasteRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo, WasteRepo $wasteRepo)
    {
        $this->middleware('cookie');
        $this->userRepo = $userRepo;
        $this->wasteRepo = $wasteRepo;
    }

    public function getCreateWaste(){

        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $frequencies = $content['frequencies'];
                $provinces = $content['provinces'];
                $localities = $content['localities'];
                return view('site.waste/create-edit-waste', compact('ads', 'types', 'frequencies', 'provinces', 'localities'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar crear un residuo. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al intentar crear un residuo. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al intentar crear un residuo. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al intentar crear un residuo. Disculpe las molestias.');
        }

    }

    public function postCreateWaste(Request $request){
        try{
            $result = $this->wasteRepo->register($request->all());

            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                return redirect('home')->with('success', $content['message']);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar el residuo. Disculpe las molestias.');
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible registrar el residuo por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al registrar el residuo. Disculpe las molestias.');
        }
    }

    public function postUpdateWaste(Request $request){
        try{
            $result = $this->wasteRepo->update($request->all());

            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                return redirect('home')->with('success', $content['message']);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
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
                return redirect()->back()->withInput()->with('error', 'No ha sido posible actualizar el residuo por los siguientes motivos:')->with('validation_errors', $errors);
            }else{
                return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al actualizar el residuo. Disculpe las molestias.');
        }
    }

    public function getPublished(){

        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                return view('site.waste.user-offers-list', compact('ads', 'types'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar sus residuos publicados. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos publicados. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos publicados. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos publicados. Disculpe las molestias.');
        }
    }

    public function getAvailableList(){
        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                return view('site.waste.available-list', compact('ads', 'types'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos disponibles. Disculpe las molestias.');
        }

    }

    public function getDemandList(){
        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                return view('site.waste.demand-list', compact('ads', 'types'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar los residuos demandados. Disculpe las molestias.');
        }

    }

    public function getTransfers(){

        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                return view('site.waste.user-transfers-list', compact('ads', 'types'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar sus residuos cedidos. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos cedidos. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos cedidos. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos cedidos. Disculpe las molestias.');
        }

    }

    public function getRequests(){

        try{
            $result = $this->wasteRepo->wasteDataForCreate();

            if($result['status'] == 200){
                // Convert body std object to array
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                return view('site.waste.user-requests-list', compact('ads', 'types'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al consultar sus residuos solicitados. Disculpe las molestias.');
            }

        }catch(ClientException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos solicitados. Disculpe las molestias.');
        }catch(ServerException $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos solicitados. Disculpe las molestias.');
        }catch(\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->withInput()->with('error', 'Ha ocurrido un error al consultar sus residuos solicitados. Disculpe las molestias.');
        }
    }

    public function getUpdateWaste($waste_id){
        try{
            $result = $this->wasteRepo->wasteDataForUpdate(array('waste_id' => $waste_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $types = $content['types'];
                $frequencies = $content['frequencies'];
                $provinces = $content['provinces'];
                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];

                // Compruebo que el residuo sea del usuario
                return view('site.waste/create-edit-waste', compact('ads', 'types', 'frequencies', 'provinces', 'localities', 'waste', 'address', 'locality'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar editar el residuo. Disculpe las molestias.');

        }

    }

    public function postOffersData(Request $request){
        $response = $this->wasteRepo->userOffersWasteData($request->all());
        $content = json_decode(json_encode($response['body']), true);
        $data = json_encode($content);
        return $data;
    }

    public function postAvailableData(Request $request){
        $response = $this->wasteRepo->availableListData($request->all());
        $content = json_decode(json_encode($response['body']), true);
        $data = json_encode($content);
        return $data;
    }

    public function postDemandData(Request $request){
        $response = $this->wasteRepo->demandListData($request->all());
        $content = json_decode(json_encode($response['body']), true);
        $data = json_encode($content);
        return $data;
    }

    public function postTransfersData(Request $request){
        $response = $this->wasteRepo->userTransfersWasteData($request->all());
        $content = json_decode(json_encode($response['body']), true);
        $data = json_encode($content);
        return $data;
    }

    public function postRequestsData(Request $request){
        $response = $this->wasteRepo->userRequestsWasteData($request->all());
        $content = json_decode(json_encode($response['body']), true);
        $data = json_encode($content);
        return $data;
    }

    public function postRequestWaste(Request $request){
        try{
            $response = $this->wasteRepo->requestWaste($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al tramitar la solicitud.');
        }

    }

    public function getShowWaste($waste_id){
        try{
            $result = $this->wasteRepo->wasteDataForShow(array('waste_id' => $waste_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $show = true;

                // Compruebo que el residuo sea del usuario
                return view('site.waste/show-waste', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'show'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar el residuo. Disculpe las molestias.');

        }

    }

    public function postDeleteWaste(Request $request){
        try{
            $response = $this->wasteRepo->deleteWaste($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al eliminar el residuo.');
        }

    }

    public function getShowTransfer($transfer_id){
        try{
            $result = $this->wasteRepo->wasteTransferRequestDataForShow(array('transfer_id' => $transfer_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $is_transfer = true;

                $owner_user = $content['owner_user'];
                $owner_activity = $content['owner_activity'];
                $owner_address = $content['owner_address'];
                $owner_locality = $content['owner_locality'];
                $owner_province = $content['owner_province'];

                $request_user = $content['request_user'];
                $request_activity = $content['request_activity'];
                $request_address = $content['request_address'];
                $request_locality = $content['request_locality'];
                $request_province = $content['request_province'];

                // Compruebo que el residuo sea del usuario
                return view('site.waste/show-transfer-request', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_transfer', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error('VER CESIÓN: '. $exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la cesión del residuo. Disculpe las molestias.');

        }
    }

    public function getShowRequest($transfer_id){

        try{
            $result = $this->wasteRepo->wasteTransferRequestDataForShow(array('transfer_id' => $transfer_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $is_request = true;

                $owner_user = $content['owner_user'];
                $owner_activity = $content['owner_activity'];
                $owner_address = $content['owner_address'];
                $owner_locality = $content['owner_locality'];
                $owner_province = $content['owner_province'];

                $request_user = $content['request_user'];
                $request_activity = $content['request_activity'];
                $request_address = $content['request_address'];
                $request_locality = $content['request_locality'];
                $request_province = $content['request_province'];

                // Compruebo que el residuo sea del usuario
                return view('site.waste/show-transfer-request', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_request', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id'));

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del el residuo. Disculpe las molestias.');

        }

    }

    public function getShowRequestPdf($transfer_id){

        try{
            $result = $this->wasteRepo->wasteTransferRequestDataForShow(array('transfer_id' => $transfer_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $is_request = true;

                $owner_user = $content['owner_user'];
                $owner_activity = $content['owner_activity'];
                $owner_address = $content['owner_address'];
                $owner_locality = $content['owner_locality'];
                $owner_province = $content['owner_province'];

                $request_user = $content['request_user'];
                $request_activity = $content['request_activity'];
                $request_address = $content['request_address'];
                $request_locality = $content['request_locality'];
                $request_province = $content['request_province'];

                $pdf = \PDF::loadView('site.waste/show-transfer-request-pdf', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_request', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id'))->setOption('viewport-size', '1366x1024');
//                return view('site.waste/show-transfer-request-pdf', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_request', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id'));
                return $pdf->download('Solicitud_de_Residuo.pdf');

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del residuo. Disculpe las molestias.');

        }

    }

    public function getShowTransferPdf($transfer_id){

        try{
            $result = $this->wasteRepo->wasteTransferRequestDataForShow(array('transfer_id' => $transfer_id));
            if($result['status'] == 200){
                $content = json_decode(json_encode($result['body']), true);
                $ads = $content['ads'];
                $type = $content['type'];
                $frequency = $content['frequency'];
                $province = $content['province'];
//                $localities = $content['localities'];
                $waste = $content['waste'];
                $address = $content['address'];
                $locality = $content['locality'];
                $is_transfer = true;

                $owner_user = $content['owner_user'];
                $owner_activity = $content['owner_activity'];
                $owner_address = $content['owner_address'];
                $owner_locality = $content['owner_locality'];
                $owner_province = $content['owner_province'];

                $request_user = $content['request_user'];
                $request_activity = $content['request_activity'];
                $request_address = $content['request_address'];
                $request_locality = $content['request_locality'];
                $request_province = $content['request_province'];

                $pdf = \PDF::loadView('site.waste/show-transfer-request-pdf', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_transfer', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id'))->setOption('viewport-size', '1366x1024');
                return $pdf->download('Solicitud_de_Residuo.pdf');

            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del residuo. Disculpe las molestias.');
            }
        }catch (ClientException $exception){
            $response = $exception->getResponse();
            if($response->getStatusCode() == 403){
                $content = json_decode($response->getBody()->getContents(), true);
                return redirect()->back()->with('error', $content['exception']);
            }else{
                return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del el residuo. Disculpe las molestias.');
            }
        }catch (\Exception $exception){
            return redirect()->back()->with('error', 'Ha ocurrido un error al intentar visualizar la solicitud del el residuo. Disculpe las molestias.');

        }

    }
}
