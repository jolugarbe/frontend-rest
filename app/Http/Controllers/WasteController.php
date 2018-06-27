<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use App\Repositories\WasteRepo;
use Carbon\Carbon;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
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
        // Object stdClass with assoc false; if assoc true convert to array
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('t_ad_id', function ($waste) {
                $type = '';
                if ($waste->t_ad_id == 1)
                    $type .= '<span class="badge badge-primary">Oferta</span>';
                else{
                    $type .= '<span class="badge badge-purple text-white">Demanda</span> -> ';

                    if($waste->acquired){
                        $type .= '<span class="badge badge-success text-white">Conseguido</span>';
                    }else{
                        $type .= '<span class="badge badge-yellow text-white">Pendiente</span>';
                    }
                }


                return $type;
            })
            ->editColumn('dangerous', function ($waste) {
                if ($waste->dangerous == 1)
                    return "SÍ";
                else
                    return "NO";
            })
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('generation_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->generation_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($waste) {
                $url_update = URL::to('/waste/update/'.$waste->id);
                $url_delete = URL::to('/waste/delete/'.$waste->id);
                $links = '';

                if($waste->t_ad_id == 2 && !$waste->acquired){
                    $links .= '<a data-waste_id="'.$waste->id.'" class="acquired-waste btn btn-square btn-success text-white m-1" data-toggle="tooltip" data-placement="top" title="Marcar como conseguido"><i class="fa fa-check" aria-hidden="true"></i></a>';
                }

                if(!$waste->acquired)
                    $links .= '<a href="'.$url_update.'" class="btn btn-square btn-info m-1" data-toggle="tooltip" data-placement="top" title="Editar publicación"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';

                $links .= '<a href="'.$url_delete.'" id="'.$waste->id.'" data-waste_id="'.$waste->id.'" class="delete-waste btn btn-square btn-danger m-1"  data-toggle="tooltip" data-placement="top" title="Eliminar publicación"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 't_ad_id', 'quantity'])
            ->make(true);
    }

    public function postAvailableData(Request $request){
        $response = $this->wasteRepo->availableListData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('user/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $link;
            })
            ->editColumn('pickup_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
            })
            ->editColumn('generation_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->generation_date)->format('d/m/Y');
            })
            ->editColumn('dangerous', function ($waste) {
                return $waste->dangerous == 1 ? "SÍ" : "NO";
            })
            ->addColumn('action', function ($waste) {
                $url_demand = URL::to('/waste/demand/'.$waste->id);
                $url_show_waste = URL::to('/waste/show/'.$waste->id);
                $links = '';
                $links .= '<a target="_blank" href="'.$url_show_waste.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver residuo"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a class="btn btn-success request-waste text-white" data-waste_id="'.$waste->id.'" data-toggle="tooltip" data-placement="top" title="Solicitar residuo"><i class="fa fa-hand-paper-o" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'creator_name'])
            ->make(true);
    }

    public function postDemandData(Request $request){
        $response = $this->wasteRepo->demandListData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('user/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $link;
            })
//            ->editColumn('pickup_date', function (Waste $waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
//            })
//            ->editColumn('generation_date', function (Waste $waste) {
//                return Carbon::createFromFormat('Y-m-d', $waste->generation_date)->format('d/m/Y');
//            })
            ->editColumn('publication_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d H:i:s', $waste->publication_date)->format('d/m/Y');
            })
            ->editColumn('dangerous', function ($waste) {
                return $waste->dangerous == 1 ? "SÍ" : "NO";
            })
            ->addColumn('action', function ($waste) {
                $url_demand = URL::to('waste/demand/'.$waste->id);
                $url_show_waste = URL::to('waste/show/'.$waste->id);
                $links = '';
                $links .= '<a target="_blank" href="'.$url_show_waste.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver residuo"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a class="btn btn-success contact-waste text-white" data-receiver_id="'.$waste->creator_user_id.'" data-waste_name="'.$waste->name.'" data-waste_id="'.$waste->id.'" data-toggle="tooltip" data-placement="top" title="Contactar con demandante"><i class="fa fa-envelope" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'creator_name'])
            ->make(true);
    }

    public function postTransfersData(Request $request){
        $response = $this->wasteRepo->userTransfersWasteData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('name', function ($waste) {
                $url = URL::to('waste/show/'.$waste->id);
                $name = '<a href="'.$url.'" target="_blank">'.$waste->name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $name;
            })
            ->editColumn('request_name', function ($waste) {
                $url = URL::to('user/show/'.$waste->owner_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->request_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';

                return $link;
            })
            ->editColumn('status', function ($waste) {
                $type = '';
                if ($waste->status_id == 1)
                    $type .= '<span class="badge badge-yellow" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 2)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 3)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 4)
                    $type .= '<span class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';

                return $type;
            })
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('pickup_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
            })
            ->editColumn('request_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->request_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($waste) {

                $url_show_transfer = URL::to('waste/user/show-transfer/'.$waste->transfer_id);
                $url_show_transfer_pdf = URL::to('waste/user/show-transfer/pdf/'.$waste->transfer_id);

                $links = '';

                if($waste->status_id == 1){
                    $links .= '<a class="btn btn-success accept-request m-1 text-white" data-transfer_id="'.$waste->transfer_id.'" data-toggle="tooltip" data-placement="top" title="Aceptar solicitud"><i class="fa fa-check" aria-hidden="true"></i></a>';
                    $links .= '<a class="btn btn-danger decline-request m-1 text-white" data-transfer_id="'.$waste->transfer_id.'" data-toggle="tooltip" data-placement="top" title="Rechazar solicitud"><i class="fa fa-close" aria-hidden="true"></i></a>';
                }

                $links .= '<a target="_blank" href="'.$url_show_transfer.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver solicitud"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_show_transfer_pdf.'" class="btn btn-purple m-1" data-toggle="tooltip" data-placement="top" title="Descargar solicitud"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'status', 'name', 'request_name'])
            ->make(true);
    }

    public function postRequestsData(Request $request){
        $response = $this->wasteRepo->userRequestsWasteData($request->all());
        $content = json_decode(json_encode($response['body']), false);
        return datatables()
            ->of($content)
            ->editColumn('name', function ($waste) {
                $url = URL::to('waste/show/'.$waste->id);
                $name = '<a href="'.$url.'" target="_blank">'.$waste->name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';
                return $name;
            })
            ->editColumn('creator_name', function ($waste) {
                $url = URL::to('user/show/'.$waste->creator_user_id);
                $link = '<a href="'.$url.'" target="_blank">'.$waste->creator_name.'   <i class="fa fa-external-link" aria-hidden="true"></i></a>';

                return $link;
            })
            ->editColumn('status', function ($waste) {
                $type = '';
                if ($waste->status_id == 1)
                    $type .= '<span class="badge badge-yellow" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 2)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 3)
                    $type .= '<span class="badge badge-danger text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';
                elseif($waste->status_id == 4)
                    $type .= '<span class="badge badge-primary text-white" data-toggle="tooltip" data-placement="top" title="'.Carbon::createFromFormat('Y-m-d H:i:s', $waste->updated_at)->format('d/m/Y H:i:s').'">'.$waste->status.'</span>';

                return $type;
            })
            ->editColumn('quantity', function ($waste) {
                $quantity = $waste->quantity . " " . $waste->measured_unit;
                return $quantity;
            })
            ->editColumn('pickup_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->pickup_date)->format('d/m/Y');
            })
            ->editColumn('request_date', function ($waste) {
                return Carbon::createFromFormat('Y-m-d', $waste->request_date)->format('d/m/Y');
            })
            ->addColumn('action', function ($waste) {
                $url_show_transfer = URL::to('waste/user/show-transfer/'.$waste->transfer_id);
                $url_show_transfer_pdf = URL::to('waste/user/show-transfer/pdf/'.$waste->transfer_id);

                $links = '';

                if($waste->status_id == 1){
                    $links .= '<a class="btn btn-danger cancel-request m-1 text-white" data-transfer_id="'.$waste->transfer_id.'" data-toggle="tooltip" data-placement="top" title="Cancelar solicitud"><i class="fa fa-close" aria-hidden="true"></i></a>';
                }

                $links .= '<a target="_blank" href="'.$url_show_transfer.'" class="btn btn-info m-1" data-toggle="tooltip" data-placement="top" title="Ver solicitud"><i class="fa fa-eye" aria-hidden="true"></i></a>';
                $links .= '<a href="'.$url_show_transfer_pdf.'" class="btn btn-purple m-1" data-toggle="tooltip" data-placement="top" title="Descargar solicitud"><i class="fa fa-cloud-download" aria-hidden="true"></i></a>';

                return $links;
            })
            ->rawColumns(['action', 'name', 'creator_name', 'status'])
            ->make(true);
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

                $status_transfer_id = $content['status_transfer_id'];
                $status_transfer_name = $content['status_transfer_name'];

                // Compruebo que el residuo sea del usuario
                return view('site.waste/show-transfer-request', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_transfer', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id', 'status_transfer_id', 'status_transfer_name'));

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

                $status_transfer_id = $content['status_transfer_id'];
                $status_transfer_name = $content['status_transfer_name'];

                // Compruebo que el residuo sea del usuario
                return view('site.waste/show-transfer-request', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_request', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id', 'status_transfer_id', 'status_transfer_name'));

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

                $status_transfer_id = $content['status_transfer_id'];
                $status_transfer_name = $content['status_transfer_name'];

                $pdf = \PDF::loadView('site.waste/show-transfer-request-pdf', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_request', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id', 'status_transfer_id', 'status_transfer_name'))->setOption('viewport-size', '1366x1024');
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

                $status_transfer_id = $content['status_transfer_id'];
                $status_transfer_name = $content['status_transfer_name'];

                $pdf = \PDF::loadView('site.waste/show-transfer-request-pdf', compact('ads', 'type', 'frequency', 'province', 'waste', 'address', 'locality', 'is_transfer', 'owner_user', 'owner_activity', 'owner_address', 'owner_locality', 'owner_province', 'request_user', 'request_activity', 'request_address', 'request_locality', 'request_province', 'transfer_id', 'status_transfer_id', 'status_transfer_name'))->setOption('viewport-size', '1366x1024');
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


    public function postWasteProposal(Request $request){
        try{
            $response = $this->wasteRepo->wasteProposal($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al enviar la propuesta.');
        }

    }


    public function postAcquiredWaste(Request $request){
        try{
            $response = $this->wasteRepo->wasteAcquired($request->all());
            $content = json_decode(json_encode($response['body']), true);
            $result = $content['message'];
            return array('result' => 'success', 'message' => $result);
        }catch (\Exception $exception){
            return array('result' => 'error', 'message' => 'Se ha producido un error al marcar el residuo como conseguido.');
        }

    }
}
