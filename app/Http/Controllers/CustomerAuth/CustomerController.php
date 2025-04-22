<?php

namespace App\Http\Controllers\CustomerAuth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Customer;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Hash;
use DB;

class CustomerController extends Controller
{
    public function showDashboard () 
    {
        return view('customer.dashboard');
    }

    public function showEditProfile ()
    {
        return view('customer.edit-profile');
    }

    public function postEditProfile (Request $request, $id)
    {
        $this->validate($request,
            [
                'password' => 'required|string',
                'newPassword' => 'required|string|min:6|max:25',
                'new_password_confirmation' => 'same:newPassword',
            ],
            [
                'password.required' => 'Bạn phải nhập mật khẩu cũ',
                'newPassword.required' => 'Bạn chưa nhập mật khẩu mới',
                'newPassword.min' => 'Mật khẩu phải từ 6 ký tự trở lên',
                'newPassword.max' => 'Mật khẩu không được quá 25 ký tự',
                'new_password_confirmation.same' => 'Mật khẩu xác nhận không khớp',
            ]
        );
        $customer = Customer::find($id);
        $customer->phone = $request->phone;
        $customer->adress = $request->adress;

        if(!empty($request->password)) {
            if (Hash::check($request->password, $user->password)) { 
                $user->fill([
                    'password' => Hash::make($request->newPassword)
                ])->save();
                Session::flash('success','Cập nhật thông tin thành công');
                $customer->save();
                return redirect('/customer/edit-profile');
            } else {
                Session::flash('error','Mật khẩu hiện tại sai.');
                return back();
            }
        }
        Session::flash('success','Cập nhật thông tin thành công');
        $customer->save();
    }

    public function showAllOrder ()
    {
        $all_transaction  = DB::table('transaction')->where('customer_id', auth()->guard('customer')->user()->id)->orderBy('created_at','desc')->get();
        return view('customer.orders', compact('all_transaction'));
    }

    public function showDetailOrder($id)
    {
        $transaction = \App\Transaction::find($id);
        $orders = $transaction->orders()->get();

        return view('customer.detail-transaction', compact('transaction','orders'));
    }

    public function showUploadedFile ()
    {
        $uploaded = \App\DonThuoc::where('customer_id', auth()->guard('customer')->user()->id)->orderBy('created_at','desc')->get();
        return view('customer.uploaded', compact('uploaded'));
    }

    public function showCustomerEditForm ($id)
    {
        $customer = Customer::find($id);
        return view('customer-auth.edit-customer', compact('customer'));
    }

    public function postCustomerEdit($id, Request $request) 
    {
        // $this->validate($request, 
        //     [

        //     ],
        //     [

        //     ]
        // );

        $customer = Customer::findOrFail($id);

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->adress = $request->adress;
        if (($request->changePassword) == 'on') {
            $this->validate($request,
                [
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
                return redirect()->back()->with(['flash_level' => 'danger','flash_message' => 'Nhập sai mật khẩu hiện tại']);   
            }
        }

        $customer->save();
        Session::flash('success','Cập nhật thông tin thành công');
        return redirect('/customer/home');
    }
}
