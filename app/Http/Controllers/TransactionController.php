<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Transaction;

use App\Notifications\AdminNotification;

use App\Order;

use DB;

use Session;

use Mail;

class TransactionController extends Controller
{
    public function getAllTransaction()
    {
        $transaction = Transaction::orderBy('created_at','desc')->get();
        return view('admin.transaction.all-transaction',['transaction'=>$transaction]);
    }

    public function viewTransaction($id)
    {
        $transaction = Transaction::find($id);
        $orders  = $transaction->orders()->get();
        return view('admin.transaction.view-transaction',['transaction'=>$transaction,'orders'=>$orders]);
    }

    public function changeStatus($id) 
    {
        $transaction = Transaction::find($id);
        $orders  = $transaction->orders()->get();

        return view('admin.transaction.change-status',['transaction'=>$transaction,'orders' => $orders]);
    }

    public function postChangeStatus($id, Request $request) {
        DB::table('transaction')->where('id', $id)->update(['status' => $request->sltStatus]);

        $transaction = DB::table('transaction')->where('id', $id)->first();
        $action_name = __FUNCTION__;
        \App\User::find(1)->notify(new AdminNotification($transaction, $action_name));
        $transaction = DB::table('transaction')->where('id', $id)->first();
        
        $config = DB::table('config')->first();
        $customer = \App\Customer::where('id', $transaction->customer_id)->first();
        if ($customer) {
            $customer_email = $transaction->customer_email;
            Mail::send('front.email.change-status',['transaction' => $transaction,'customer_email' => $customer_email], function($msg) use ($transaction, $config, $customer_email) {
                $msg->from('cskhkhoinguyen@gmail.com','Nội thất Khôi Nguyên - Cập nhật trạng thái đơn hàng');
                $msg->to($customer_email,'Cập nhật trạng thái đơn hàng')->subject('Cập nhật trạng thái đơn hàng từ website!');
            });
        }

        Mail::send('front.email.change-status',['transaction' => $transaction], function($msg) use ($transaction, $config) {
            $msg->from('cskhkhoinguyen@gmail.com','Nội thất Khôi Nguyên - Cập nhật trạng thái đơn hàng');
            $msg->to($config->email,'Cập nhật trạng thái đơn hàng')->subject('Cập nhật trạng thái đơn hàng từ website!');
        });

        Session::flash('success','Cập nhật trạng thái thành công !');
        return redirect()->route('transaction.viewTransaction', $id);
    }


    
}
