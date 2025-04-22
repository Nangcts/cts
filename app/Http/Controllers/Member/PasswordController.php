<?php

namespace App\Http\Controllers\Member;

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

    protected $guard = 'members';
    protected $broker = 'members';

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:members');
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

        if (view()->exists('auth.passwords.email')) {
            return view('auth.passwords.email');
        }

        return view('auth.emails.password');
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

        if (view()->exists('auth.passwords.reset')) {
            return view('auth.passwords.reset',['token'=>$token, 'email'=>$email]);
        }

        return view('passwords.reset', ['token'=>$token, 'email'=>$email]);
    }


}
