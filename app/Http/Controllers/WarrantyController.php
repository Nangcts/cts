<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Excel;
use File;
use DB;
use Session;
use App\Warranty;
use App\Customer;

class WarrantyController extends Controller
{
    public function getAdd ()
    {
        return view('admin.warranty.add');
    }
    public function postAdd (Request $r)
    {
        if ($r->hasFile('iptWarranty')) {
            $file = $r->file('iptWarranty');
            $file_name = $file->getClientOriginalName();
            $path_file = $file->getRealPath();

            $data = Excel::load($path_file, function($reader) {
            })->get();
            foreach ($data as $value) {
                $serial[] = $value->serial;
                    
            }           
            if (count(array_unique($serial)) < count($serial)) {
                Session::flash('error','Có số Serial trùng nhau trong danh sách tải lên, Vui lòng kiểm tra lại danh sách.');
                return view('admin.warranty.add');
            } else 
            {
                foreach ($serial as $item) {
                    $check_serial = DB::table('warranty')->where('serial',$item)->count();
                    if ($check_serial == 0) {
                        $data_insert[] = ['serial' => $item,'status' => 0,'created_at' => \Carbon\Carbon::now(),'updated_at' => \Carbon\Carbon::now()];
                    }
                    else
                    {
                        Session::flash('error','Số Serial: '.$item.' bạn nhập vào đã tồn tại trên hệ thống, vui lòng kiểm tra lại !');
                        return redirect()->route('admin.warranty.getAdd');
                    }
                }
                // echo "<pre>";
                // print_r($data_insert);
                // echo "</pre>";
                // die();
                if (isset($data_insert)) {
                    DB::table('warranty')->insert($data_insert);
                }
                Session::flash('success','Bạn đã tải thành công danh sách Serial sản phẩm !');
                return redirect('admin/warranty/list');
            }

        }
    }

    public function getAddActive ()
    {
        return view('admin.warranty.addActive');
    }
    public function postAddActive (Request $r)
    {
        if ($r->hasFile('iptWarranty')) {
            $file = $r->file('iptWarranty');
            $file_name = $file->getClientOriginalName();
            $path_file = $file->getRealPath();

            $data = Excel::load($path_file, function($reader) {
            })->get();
            foreach ($data as $value) {
                $serial[] = $value->serial;
                    
            }           
            if (count(array_unique($serial)) < count($serial)) {
                Session::flash('error','Có số Serial trùng nhau trong danh sách tải lên, Vui lòng kiểm tra lại danh sách.');
                return view('admin.warranty.addActive');
            } else 
            {
                foreach ($serial as $item) {
                    $check = DB::table('warranty')->where('serial',$item)->first();
                    if (isset($check)) {
                        DB::table('warranty')->where('serial',$item)->update(['status' => 1, 'active' => \Carbon\Carbon::now(),'updated_at' => \Carbon\Carbon::now()]);
                    }
                }
                Session::flash('success','Bạn đã tải thành công danh sách Serial sản phẩm !');
                return redirect('admin/warranty/list');
            }

        }
    }

    public function postWarrantyCheck(Request $r)
    {
        $this->validate($r, 
            [
                'iptWarrantyCode' => 'required',
 
            ],
            [
                'iptWarrantyCode.required' => 'Bạn chưa nhập mã bảo hành',
            ]
        );
        $warranty_code = $r->iptWarrantyCode;
        if (Warranty::where('serial', '=', $warranty_code)->where('status',1)->exists()) {
            $warranty_info = Warranty::where('serial',$warranty_code)->with('customer')->first();
            return view('front.pages.warranty',['data' => $warranty_info]);
        } else
        {
            $error = "Không tìm thấy mã bảo hành của bạn trên hệ thống !";
            return view('front.pages.warranty',['error' => $error]);
        }
    }

    public function getWarrantyCheck()
    {
        return view('front.pages.warranty');
    }

    public function getEdit($id)
    {
        $warranty = Warranty::findOrFail($id);
        return view('admin.warranty.edit',['warranty' => $warranty]);
    }

    public function postEdit (Request $r, $id)
    {
        $this->validate($r, 
            [
                'iptSerial' => 'required|unique:warranty,serial,'.$id,
                'iptActive'    => 'required',      
            ],
            [
                'iptSerial.required' => 'Chưa nhập mã bảo hành',
                'iptSerial.unique' => 'Mã bảo hành đã tồn tại trên hệ thống',
                'iptActive.required'    => 'Chưa nhập ngày active bảo hành',  
            ]
        );
        $warranty = Warranty::findOrFail($id);
        $warranty->serial = $r->iptSerial;
        $warranty->active = $r->iptActive;
        $warranty->save();

        Session::flash('success','Sửa bảo hành thành công!');
        return redirect('admin/warranty/list');
    }

    public function getList()
    {
        $list = Warranty::all();
        return view('admin.warranty.list',['list' => $list]);
    }
}
