<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Members;

use Auth,DB;

use Session;

class MemberController extends Controller
{

    public function getList() {
        $members = Members::all();
		return view('admin.member.list',['members'=>$members]);
    }

    public function getDelete($id) {
    	$member = Members::findOrFail($id);

    	$member->delete($id);

    	return redirect('admin/member/list')->with(['flash_level' => 'success','flash_message' => 'Xóa tài khoản thành công']);
    }

    public function getDangthue ()
    {
    	$member_id = Auth::guard('members')->user()->id;
    	$member_trans = DB::table('transaction')->where('user_id',$member_id)->get();
    	foreach ($member_trans as $key => $value) {
    		$trans_id[$key] = $value->id;
    	}
    	$data['member_order'] = DB::table('order')->whereIn('trans_id',$trans_id)->where('status',1)->where('loai_giao_dich',0)->get();
    	return view('admin.member.dangthue', isset($data) ? $data : null);

    }

    public function getAll ()
    {
    	$member_id = Auth::guard('members')->user()->id;
    	$member_trans = DB::table('transaction')->where('user_id',$member_id)->get();
    	foreach ($member_trans as $key => $value) {
    		$trans_id[$key] = $value->id;
    	}
    	$data['member_product'] = DB::table('order')->whereIn('trans_id',$trans_id)->get();
        return view('admin.member.all', isset($data) ? $data : null);

    }

    public function getDatra () {
    	$member_id = Auth::guard('members')->user()->id;
    	$member_trans = DB::table('transaction')->where('user_id',$member_id)->get();
    	foreach ($member_trans as $key => $value) {
    		$trans_id[$key] = $value->id;
    	}
    	$member_order = DB::table('order')->whereIn('trans_id',$trans_id)->get();
    	foreach ($member_trans as $key => $value) {
    		$product_id[$key] = $value->id;
    	}
    	$data['member_product'] = DB::table('products')->whereIn('id',$product_id)->get();
    	return view('admin.member.all', isset($data) ? $data : null);
    }

    public function confirmTra ($id)
    {
        $order = DB::table('order')->where('id',$id)->first();
        if (isset($order)) {
            $current_time = gmdate("Y-m-d H:i:s",time()+7*3600);
            DB::table('order')->where('id',$id)->update(['status' => 0,'ngay_tra' =>$current_time]);
            DB::table('products')->where('id',$order->product_id)->where('status',1)->update(['status' => 0]);
        }

        Session::flash('success','Xác nhận đã trả sản phẩm thành công !');
        return back();
        
    }

}
