<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use App\Repositories\WasteRepo;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        return view('site.waste.available-list');
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
}
