<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\ActivityRepo;
use App\Repositories\LocalityRepo;
use App\Repositories\ProvinceRepo;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $activityRepo;
    protected $provinceRepo;
    protected $localityRepo;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ActivityRepo $activityRepo, ProvinceRepo $provinceRepo, LocalityRepo $localityRepo)
    {
        $this->middleware('guest');
        $this->activityRepo = $activityRepo;
        $this->provinceRepo = $provinceRepo;
        $this->localityRepo = $localityRepo;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function showRegistrationForm()
    {
        $activities = $this->activityRepo->all();
        $activities = $activities['body'];

        $provinces = $this->provinceRepo->all();
        $provinces = $provinces['body'];

        $localities = $this->localityRepo->all();
        $localities = $localities['body'];

        return view('auth.register', compact('activities', 'provinces', 'localities'));
    }
}
