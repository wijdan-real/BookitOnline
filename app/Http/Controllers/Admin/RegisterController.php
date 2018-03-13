<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Post;
use App\UserProfile;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Auth;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin');


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
            'lastname' => 'required|string|max:255',
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
        $admin = Admin::create([
            'name' => $data['name'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);


      //  Post::create([
         //   'user_id' => $user->id,
        //]);


         return $admin;

    }
    public function showRegistrationForm()
    {
        return view('admin.register');
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($admin = $this->create($request->all())));

        $this->guard()->login($admin);

        return $this->registered($request, $admin)
            ?: redirect($this->redirectPath());
    }
    protected function guard()
    {
        return Auth::guard('admin');
    }
    protected function registered(Request $request, $admin)
    {
        //
    }


}
