<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepo;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    protected $userRepo;

    function __construct(UserRepo $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function dashboard()
    {
        $result = $this->userRepo->adminDashboard();
        $result = json_decode(json_encode($result['body']), true);
        $user = $result['user'];
        $total_users = $result['total_users'];
        $total_transfers = $result['total_transfers'];
        $total_demand = $result['total_demand'];
        $total_offers = $result['total_offers'];
        return view('admin.dashboard', compact('total_offers', 'total_demand', 'total_users', 'total_transfers'));
    }
}
