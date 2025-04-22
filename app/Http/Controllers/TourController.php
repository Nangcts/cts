<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Tour;

use App\Diemden;

use File;

use Session;

use App\DanhmucTour;

use DB;

use Image;

class TourController extends Controller
{
    
    public function getAdd ()
    {
    	$list_cate = DanhmucTour::all();

    	$list_diemden = Diemden::all();
    	return view('admin.tour.add',['list_cate' => $list_cate,'list_diemden' => $list_diemden]);
    }

    public function postAdd (Request $r)
    {
    	$this->validate($r, 
            [
				'sltCate' => 'required',
				'sltXuatphat' => 'required',
				'iptName'    => 'required|unique:products,name',
				'iptNgaydi' => 'required|date|after:today',
                'iptTime' => 'required',
                'iptHanhtrinh' => 'required',
				'iptPrice'   => 'required|integer',
				'iptImage'   => 'required|image',
				'txtIntro'   => 'required',
				'txtBody'    => 'required',		
        	],
        	[
                'sltCate.required' => 'Chưa chọn danh mục',
                'sltXuatphat.required' => 'Chưa chọn điểm xuất phát',
                'iptName.required'    => 'Chưa nhập tên',
                'iptName.unique'      => 'Tên Tour đã tồn tại',
                'iptNgaydi.required' => 'Chưa chọn ngày đi',
                'iptNgaydi.date' => 'Định dạng ngày tháng sai',
                'iptNgaydi.after' => 'Ngày đi phải sau ngày hiện tại',
                'iptPrice.required'    => 'Chưa nhập giá',
                'iptPrice.integer'    => 'Giá phải là số nguyên dương',
                'iptImage.required'   => 'Bạn chưa nhập ảnh sản phẩm', 
                'iptImage.image'      => 'Định dạng ảnh không hợp lệ',
                'txtIntro.required'   => 'Chưa nhập mô tả ngắn',
				'txtBody.required'    => 'Chưa nhập nội dung tour',
                'iptTime.required' => 'Chưa nhập thời gian cho Tour',
                'iptHanhtrinh.required' => 'Chưa nhập hành trình',	     
    		]
    	);

    	$tour = new Tour;

    	$tour->cate_id =$r->sltCate;
    	$tour->diemden_id=$r->sltXuatphat;
    	$tour->name = $r->iptName;
    	$tour->intro = $r->txtIntro;
        $tour->thoi_gian = $r->iptTime;
        $tour->hanh_trinh = $r->iptHanhtrinh;
    	$tour->price = $r->iptPrice;
    	$tour->ngay_di = $r->iptNgaydi;
    	$tour->order = $r->iptOrder;
    	$tour->keywords = $r->txtKeywords;
    	$tour->body = $r->txtBody;

		if ($r->hasFile('iptImage')) {
			$file = $r->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/tour/';
			while (file_exists('public/upload/tour/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			// Chuyển ảnh vào folder và đưa về size 600x600
			$file->move($des_path, $picture);
			$img_resize = Image::make('public/upload/tour/'.$picture);
            $img_resize->resize(800,500);
            $img_resize->save();
            // lưu vào bảng tour
			$tour->image = $picture;
		}
		$tour->save();

		Session::flash('success','Thêm Tour thành công !');
		return redirect('admin/tour/list');
    }

    public function getEdit ($id)
    {
    	$list_cate = DanhmucTour::all();
    	$list_diemden = Diemden::all();
    	$tour = Tour::find($id);

    	return view('admin.tour.edit',['list_cate' => $list_cate, 'list_diemden' => $list_diemden,'tour' => $tour]);

    }

    public function postEdit (Request $r, $id)
    {
    	$this->validate($r, 
            [
				'sltCate' => 'required',
				'sltXuatphat' => 'required',
				'iptName'    => 'required|unique:products,name,'.$id,
				'iptNgaydi' => 'required|date|after:today',
				'iptPrice'   => 'required|integer',
                'iptTime' => 'required',
                'iptHanhtrinh' => 'required',
				'iptImage'   => 'image',
				'txtIntro'   => 'required',
				'txtBody'    => 'required',		
        	],
        	[
                'sltCate.required' => 'Chưa chọn danh mục',
                'sltXuatphat.required' => 'Chưa chọn điểm xuất phát',
                'iptName.required'    => 'Chưa nhập tên',
                'iptName.unique'      => 'Tên Tour đã tồn tại',
                'iptNgaydi.required' => 'Chưa chọn ngày đi',
                'iptNgaydi.date' => 'Định dạng ngày tháng sai',
                'iptNgaydi.after' => 'Ngày đi phải sau ngày hiện tại',
                'iptPrice.required'    => 'Chưa nhập giá',
                'iptPrice.integer'    => 'Giá phải là số nguyên dương',
                'iptImage.required'   => 'Bạn chưa nhập ảnh sản phẩm', 
                'iptImage.image'      => 'Định dạng ảnh không hợp lệ',
                'txtIntro.required'   => 'Chưa nhập mô tả ngắn',
				'txtBody.required'    => 'Chưa nhập nội dung tour',	   
                'iptTime.required' => 'Chưa nhập thời gian cho Tour',
                'iptHanhtrinh.required' => 'Chưa nhập hành trình',  
    		]
    	);

    	$tour = Tour::findOrFail($id);

    	$tour->cate_id =$r->sltCate;
    	$tour->diemden_id=$r->sltXuatphat;
    	$tour->name = $r->iptName;
    	$tour->intro = $r->txtIntro;
        $tour->intro = $r->txtIntro;
        $tour->thoi_gian = $r->iptTime;
         $tour->hanh_trinh = $r->iptHanhtrinh;
    	$tour->price = $r->iptPrice;
    	$tour->ngay_di = $r->iptNgaydi;
    	$tour->order = $r->iptOrder;
    	$tour->keywords = $r->txtKeywords;
    	$tour->body = $r->txtBody;

		if ($r->hasFile('iptImage')) {

			$file = $r->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/tour/';
			while (file_exists('public/upload/tour/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			// Chuyển ảnh vào folder và đưa về size 600x600
			$file->move($des_path, $picture);
			$img_resize = Image::make('public/upload/tour/'.$picture);
            $img_resize->resize(800,500);            
            $img_resize->save();
            // Xóa ảnh cũ
            $old_img = 'public/upload/tour/'.$tour->image;
            if (file_exists($old_img)) {
            	File::delete($old_img);
            }
            // lưu vào bảng tour
			$tour->image = $picture;
		}
		$tour->save();

		Session::flash('success','Sửa Tour thành công !');
		return redirect('admin/tour/list');
    }

    public function getList ()
    {
    	$list = DB::table('tour')->get();

    	return view('admin.tour.list',['list' => $list]);
    }

    public function getDelete ($id)
    {
    	$tour = DB::table('tour')->where('id',$id)->first();
    	if (isset($tour)) {
    		$image = 'public/upload/tour/'.$tour->image;
    		if (file_exists($image)) {
    			File::delete($image);
    		}
    		DB::table('tour')->where('id',$id)->delete();
    		Session::flash('success','Xóa Tour thành công !');
    		return redirect('admin/tour/list');
    	}
    }
}
