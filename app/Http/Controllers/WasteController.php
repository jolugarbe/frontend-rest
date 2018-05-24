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

    public function getOwnWasteList(){
        return view('site.waste.owner-list');
    }
}
