<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $userRepo;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepo $userRepo)
    {
        $this->middleware('cookie');
        $this->userRepo = $userRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = $this->userRepo->profile();
        $result = json_decode(json_encode($result['body']), true);
        $user = $result['user'];
        $total_waste = $result['total_waste'];
        $total_transfers = $result['total_transfers'];
        $total_requests = $result['total_requests'];
        return view('home', compact('user', 'total_waste', 'total_transfers', 'total_requests'));
    }
}
