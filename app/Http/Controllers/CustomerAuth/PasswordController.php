<?php

namespace App\Http\Controllers\CustomerAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Members;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;


    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware());
    }

    public function getEmail()
    {
        return $this->showLinkRequestForm();
    }

    public function showLinkRequestForm()
    {
        if (property_exists($this, 'linkRequestView')) {
            return view($this->linkRequestView);
        }

        if (view()->exists('admin.superadmin.passwords.email')) {
            return view('admin.superadmin.passwords.email');
        }

        return view('admin.superadmin.emails.password');
    }

    public function showResetForm(Request $request, $token = null)
    {

        if (is_null($token)) {
            return $this->getEmail();
        }
        $email = $request->input('email');

        if (property_exists($this, 'resetView')) {
            return view($this->resetView,['token'=>$token, 'email'=>$email]);
        }

        if (view()->exists('admin.superadmin.passwords.reset')) {
            return view('admin.superadmin.passwords.reset',['token'=>$token, 'email'=>$email]);
        }

        return view('admin.superadmin.passwords.reset', ['token'=>$token, 'email'=>$email]);
    }


}
