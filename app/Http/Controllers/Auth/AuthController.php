<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;

class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;
    protected $redirectTo = '/login';
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getLogin() {
        return view('login.login');
    }

    public function postLogin(Request $request) {
        if (Auth::guard('web')->attempt(['username' => $request->txtUsername, 'password' => $request->txtPassword])) {            
            return redirect()->route('dashboard');
        } else {
            Session::flash('error','Đăng nhập thất bại');
            return redirect()->route('login');
        }

    } 
}
