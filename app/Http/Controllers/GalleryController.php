<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\CateGallery;

use App\Gallery;

use App\Gallery_Images;

use Session;

use Image;

use DB;

use File;

class GalleryController extends Controller
{
	public function getAdd()
    {
    	$data['cate_gallery'] = CateGallery::all();

    	return view('admin.gallery.add', isset($data) ? $data : null);
    }

    public function postAdd (Request $request)
    {
		$this->validate($request, [
			'sltCate'    => 'required',
			'iptName'    => 'required|unique:gallery,g_title', 
			'iptAlbum' => 'required',

	    	],
	    	[
	    		'sltCate.required' => 'Chưa chọn danh mục',
	    		'iptName.required' => 'Chưa nhập tên Album',
	            'iptName.unique' => 'Tên Album đã tồn tại',
	            'iptAlbum.required' => 'Bạn chưa chọn ảnh tải lên',

			]
    	);

		$gallery = new Gallery;

        $gallery->g_title       = $request->iptName;
        $gallery->g_cate_id = $request->sltCate;
        $gallery->g_intro      = $request->txtIntro;
        $gallery->save();
    	// Lưu ảnh vào folder upload
		if ($request->hasFile('iptAlbum')) {
			$file_album = $request->file('iptAlbum');
			foreach ($file_album as $file) {
				$file_name = $file->getClientOriginalName();
				$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
				$file_name = str_slug($file_name);
				$file_extension = $file->getClientOriginalExtension();
				$picture = $file_name.'.'.$file_extension;
				$des_path = base_path().'/public/upload/gallery/';
				while (file_exists('public/upload/gallery/'.$picture)) {
					$picture = str_random(5)."_".$picture;
				}
				// Chuyển ảnh vào folder
				$file->move($des_path, $picture);
				$img_resize = Image::make('public/upload/gallery/'.$picture);
	            $img_resize->resize(600,600);
	            $img_resize->save();
				// lưu vào bảng gallery_images
				$gallery_image = new Gallery_Images;

				$gallery_image->gallery_id = $gallery->id;
				$gallery_image->img_name = $picture;
				$gallery_image->save();
			}
		}
		Session::flash('success','Tạo Album ảnh thành công');
		return redirect()->route('admin.gallery.view',$gallery->id);    	
    }

    public function getView($id)
    {
    	return view('admin.gallery.view',['id' => $id]);
    }

    public function getEdit($id)
    {
    	$gallery = DB::table('gallery')->where('id',$id)->first();
    	$list = CateGallery::all();
    	return view('admin.gallery.edit',['gallery' => $gallery,'list' => $list]);
    }

    public function postEdit (Request $r,$id)
    {
    	$this->validate($r, [
			'sltCate'    => 'required',
			'iptName'    => 'required|unique:gallery,g_title,'.$id,	
	    	],
	    	[
				'sltCate.required' => 'Chưa chọn danh mục',
				'iptName.required' => 'Chưa nhập tên tài liệu',
				'iptName.unique'   => 'Tên tài liệu đã tồn tại',
			]
    	);
    	$gallery = Gallery::findOrFail($id);

    	$gallery->g_cate_id = $r->sltCate;
    	$gallery->g_title = $r->iptName;
        $gallery->slug = null;
        $gallery->update(['g_title' => $r->iptName]);   
    	$gallery->g_intro = $r->txtIntro;
    	$gallery->save();

    	// Nếu them anh mới
		if ($r->hasFile('iptAlbum')) {
			$file_album = $r->file('iptAlbum');
			foreach ($file_album as $file) {
				$file_name = $file->getClientOriginalName();
				$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
				$file_name = str_slug($file_name);
				$file_extension = $file->getClientOriginalExtension();
				$picture = $file_name.'.'.$file_extension;
				while (file_exists('public/upload/gallery/'.$picture)) {
					$picture = rand(5,10)."_".$picture;
				}
				$des_path = base_path().'/public/upload/gallery/';
				// Chuyển ảnh vào folder
				$file->move($des_path, $picture);
				$img_resize = Image::make('public/upload/gallery/'.$picture);
	            $img_resize->resize(600,600);
	            $img_resize->save();
				// lưu vào bảng gallery_images
				$gallery_image = new Gallery_Images;

				$gallery_image->gallery_id = $gallery->id;
				$gallery_image->img_name = $picture;
				$gallery_image->save();
			}
		}
    	// Lưu vào database
		Session::flash('success','Sửa Album ảnh thành công');
		return redirect()->route('admin.gallery.view',$gallery->id);

    }

    public function getList () 
    {
    	$data['list'] = DB::table('gallery')->get();
    	return view('admin.gallery.list', isset($data) ? $data : null);
    }

    public function getDelete ($id)
    {
    	$delete = Gallery::Find($id);
    	if (isset($delete)) {
    		// xóa ảnh ở bảng Gallery_Images
    		$gallery_images = DB::table('gallery_images')->where('gallery_id',$id)->get();
    		if (isset($gallery_images)) {
    			// Xóa ảnh trong Folder trước
    			foreach ($gallery_images as $val) {
    				$delete_img = 'public/upload/gallery/'.$val->img_name;
    				if (file_exists($delete_img)) {
    					File::delete($delete_img);
    				}
    				DB::table('gallery_images')->where('id',$val->id)->delete();
    			}
    		}
    		// Xóa trong bảng Gallery
    		DB::table('gallery')->where('id',$id)->delete();
    		Session::flash('success','Xóa Album thành công');
    		return redirect('admin/gallery/list');
    	} else {
    		Session::flash('error','Xóa Album không thành công');
    		return redirect('admin/gallery/list');
    	}
    }}
