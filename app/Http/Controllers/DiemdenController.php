<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Diemden;

use File;

use Session;

use DB;

class DiemdenController extends Controller
{
    public function getAdd ()
    {
    	return view('admin.xuatphat.add');
    }

    public function postAdd (Request $r)
    {
    	$this->validate($r,
    	    [
    	    	'iptName' => 'required|unique:diemden,name',
	        ],
	        [
				'iptName.required' => 'Chưa nhập tên',
				'iptName.unique'   => 'Tên đã tồn tại, vui lòng nhập tên khác !',
       		]
        );

		$xuatphat        = new Diemden;
		
		$xuatphat->name  = $r->iptName;
		$xuatphat->order = $r->iptOrder;

		$xuatphat->save();

        Session::flash('success','Thêm điểm xuất phát thành công !');
		return redirect('/admin/xuat-phat/list');
    }

    public function getEdit ($id)
    {
        $xuatphat = Diemden::findOrFail($id);
        return view('admin.xuatphat.edit',['xuatphat' => $xuatphat]);
    }

    public function postEdit (Request $r, $id)
    {
        $this->validate($r,
            [
                'iptName' => 'required|unique:diemden,name,'.$id,
            ],
            [
                'iptName.required' => 'Chưa nhập tên',
                'iptName.unique'   => 'Tên đã tồn tại, vui lòng nhập tên khác !',
            ]
        );

        $xuatphat        = Diemden::findOrFail($id);
        
        $xuatphat->name  = $r->iptName;
        $xuatphat->order = $r->iptOrder;

        $xuatphat->save();
        
        Session::flash('success','Sửa điểm xuất phát thành công !');
        return redirect('/admin/xuat-phat/list');
    }

    public function getList ()
    {
        $list = Diemden::all();

        return view('admin.xuatphat.list',['list' => $list]);
    }
}
