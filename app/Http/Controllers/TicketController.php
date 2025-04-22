<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use File;

use Session;

use App\Cate;

use App\Hangbay;

use App\Duongbay;

use App\Ticket;

use DB;

use Image;

class TicketController extends Controller
{
    
    public function getAdd ()
    {
    	$list_hangbay = Hangbay::all();
    	$list_duongbay = Duongbay::all();
    	return view('admin.ticket.add',['list_hangbay' => $list_hangbay,'list_duongbay' => $list_duongbay]);
    }

    public function postAdd (Request $r)
    {
    	$this->validate($r, 
            [
				'sltHangbay' => 'required',
				'iptName'    => 'required|unique:ticket,name',
				'iptImage'   => 'required|image',
				'txtBody'    => 'required',		
        	],
        	[
                'sltHangbay.required' => 'Chưa chọn Hãng hàng không',
                'iptName.required'    => 'Chưa nhập tiêu đề',
                'iptName.unique'      => 'Tiêu đề đã tồn tại',
                'iptImage.required'   => 'Bạn chưa nhập ảnh đại diện', 
                'iptImage.image'      => 'Định dạng ảnh không hợp lệ',
				'txtBody.required'    => 'Chưa nhập nội dung cập nhật vé',	     
    		]
    	);

    	$ticket = new Ticket;

    	$ticket->hangbay_id =$r->sltHangbay;
    	$ticket->name = $r->iptName;
    	$ticket->intro = $r->txtIntro;
    	$ticket->order = $r->iptOrder;
    	$ticket->keywords = $r->txtKeywords;
    	$ticket->body = $r->txtBody;

		if ($r->hasFile('iptImage')) {
			$file = $r->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/ticket/';
			while (file_exists('public/upload/ticket/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			// Chuyển ảnh vào folder và đưa về size 600x600
			$file->move($des_path, $picture);
			$img_resize = Image::make('public/upload/ticket/'.$picture);
            $img_resize->resize(800,535);
            $img_resize->save();
            // lưu vào bảng tour
			$ticket->image = $picture;
		}
		$ticket->save();

		Session::flash('success','Thêm Vé thành công !');
		return redirect('admin/ticket/getList');
    }

    public function getEdit ($id)
    {
        $ticket = Ticket::findOrFail($id);
    	$hangbay = Hangbay::all();

    	return view('admin.ticket.edit',['hangbay' => $hangbay, 'ticket' => $ticket]);

    }

    public function postEdit (Request $r, $id)
    {
    	$this->validate($r, 
            [
                'sltHangbay' => 'required',
                'iptName'    => 'required|unique:ticket,name,'.$id,
                'iptImage'   => 'image',
                'txtBody'    => 'required',     
            ],
            [
                'sltHangbay.required' => 'Chưa chọn Hãng hàng không',
                'iptName.required'    => 'Chưa nhập tên',
                'iptName.unique'      => 'Tiêu đề đã tồn tại',
                'iptImage.image'      => 'Định dạng ảnh không hợp lệ',
                'txtBody.required'    => 'Chưa nhập nội dung cập nhật vé',      
            ]
        );

    	$ticket = ticket::findOrFail($id);

        $ticket->hangbay_id =$r->sltHangbay;
        $ticket->name = $r->iptName;
        $ticket->intro = $r->txtIntro;
        $ticket->order = $r->iptOrder;
        $ticket->keywords = $r->txtKeywords;
        $ticket->body = $r->txtBody;

		if ($r->hasFile('iptImage')) {

			$file = $r->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/ticket/';
			while (file_exists('public/upload/ticket/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			// Chuyển ảnh vào folder và đưa về size 600x600
			$file->move($des_path, $picture);
			$img_resize = Image::make('public/upload/ticket/'.$picture);
            $img_resize->resize(800,535);
            $img_resize->save();
            // Xóa ảnh cũ
            $old_img = 'public/upload/ticket/'.$ticket->image;
            if (file_exists($old_img)) {
            	File::delete($old_img);
            }
            // lưu vào bảng tour
			$ticket->image = $picture;
		}
		$ticket->save();

		Session::flash('success','Sửa Vé thành công !');
		return redirect('admin/ve-may-bay/list');
    }

    public function getList ()
    {
    	$list = DB::table('ticket')->get();

    	return view('admin.ticket.list',['list' => $list]);
    }

    public function getDelete ($id)
    {
    	$ticket = DB::table('ticket')->where('id',$id)->first();
    	if (isset($ticket)) {
    		$image = 'public/upload/ticket/'.$ticket->image;
    		if (file_exists($image)) {
    			File::delete($image);
    		}
    		DB::table('ticket')->where('id',$id)->delete();
    		Session::flash('success','Xóa Vé thành công !');
    		return redirect('admin/ve-may-bay/list');
    	}
    }
}
