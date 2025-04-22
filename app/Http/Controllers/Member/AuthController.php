<?php

namespace App\Http\Controllers\Member;

use App\Members;
use Validator;
use Auth,DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use File,Hash;
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = 'member/success';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    public function getLogin () {
        return view('auth.login');
    }
    public function postLogin(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard('members')->attempt($credentials, $request->has('remember'))) {
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
    public function loginSuccess() {
        if (Auth::guard('members')->check()) {
            $current_user_id = Auth::guard('members')->user()->id;
            $member = DB::table('members')->where('id',$current_user_id)->first();
            return view('auth.profile',['member' => $member]);
        } else {
            echo "<script>
                    alert('Bạn không có quyền truy cập vào trang này!');
                    window.location ='" .url('/'). "'
                    
            </script>";
        }

    }
    public function getRegister() {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        Auth::guard('members')->login($this->create($request->all()));
        $email = $request->get('email');
        return redirect()->route('profile',$email);

    }
    public function getProfile($email) {
        $member = DB::table('members')->where('email',$email)->first();
        return view('auth.profile',['member' => $member]);
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
            'email' => 'required|email|max:255|unique:members,email',
            'password' => 'required|min:6|confirmed',
            'adress' => 'required',
            'phone' => 'required|unique:members,phone',
            'avata' => 'required|image',
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

        if (!empty($data['avata'])) {   
            $avata = $data['avata'];
            $avata_name = $data['avata']->getClientOriginalName();
            $avata->move('public/upload/avata/',$avata_name);
        }
        return Members::create([
            'name' => $data['name'],
            'avata' => $avata_name,
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'],
            'adress' => $data['adress'],
        ]);
    }
    public function editProfile($id) {
        if (Auth::guard('members')->check()) {
            $member = Members::findOrFail($id);
            return view('auth.editprofile',['member'=>$member]);
        } else {
            return redirect('/');
        }
        
    }
    public function postEditProfile(Request $request, $id) {

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required|unique:members,phone,'.$id,
            'adress' => 'required',
        ],
        [
            'name.required' => 'Bạn chưa nhập tên',
            'phone.required' => 'Bạn chưa nhập số điện thoại',
            'phone.unique' => 'Số điện thoại đã được sử dụng',
            'adress.required' => 'Bạn chưa nhập địa chỉ',
        ]
        );
        $member = Members::findOrFail($id);
        $member->name = $request->name;
        $member->phone = $request->phone;
        $member->adress = $request->adress;
        if (($request->changePassword) == 'on') {
            $this->validate($request,[
                'password' => 'required',
                'newPassword' => 'required|min:6|max:12',
                'password_confirmation' => 'same:newPassword',
            ],
            [
                'password.required' => 'Bạn phải nhập mật khẩu cũ',
                'newPassword.required' => 'Bạn chưa nhập mật khẩu mới',
                'newPassword.min' => 'Mật khẩu phải từ 6 ký tự trở lên',
                'required.max' => 'Mật khẩu không được quá 12 ký tự',
                'password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
            ]
            );
            if (Hash::check($request->password, $member->password)) { 
               $member->fill([
                    'password' => Hash::make($request->newPassword)
               ])->save();
            } else {
                 return redirect()->route('editProfile',$id)->with(['flash_level' => 'danger','flash_message' => 'Nhập sai mật khẩu hiện tại']);   
            }
        }
        $current_avata = 'public/upload/avata/'.$member->avata;
        if ($request->hasFile('avata')) {
            $avata = $request->file('avata');
            $avata_name = $avata->getClientOriginalName();
            while (file_exists('public/upload/avata/'.$avata_name)) {
                $avata_name = str_random(4)."_".$avata_name;
            }
            $avata->move('public/upload/avata/',$avata_name);
            $member->avata = $avata_name;
            // Xóa avata cũ
            if (File::exists($current_avata)) {
                File::delete($current_avata);
            }
        }
        $member->save();

        return redirect()->route('editProfile',$id)->with(['flash_level' => 'success','flash_message' => 'Cập nhật thông tin cá nhân thành công']);

    }


}    