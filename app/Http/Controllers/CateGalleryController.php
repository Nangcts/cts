<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

use App\CateGallery;

use Session;


class CateGalleryController extends Controller
{
    
    public function getAdd () 
    {
    	$data['list'] = CateGallery::all();
    	return view('admin.categallery.add', isset($data) ? $data : null);
    }
    public function postAdd(Request $request) {
        $check_id = $request->sltParent;
        $this->validate($request, [
            'iptName' => 'required|unique:cate_gallery,name,null,id,parent_id,'.$check_id,
            ],
            [
                'iptName.required' => 'Bạn chưa nhập tên danh mục',
                'iptName.unique'    => 'Tên danh mục đã tồn tại',
            ]
        );

        $categallery_add = new CateGallery;
        $categallery_add->parent_id = $request->sltParent;
        $categallery_add->name	 = $request->iptName;      
        $categallery_add->sort_order = $request->iptOrder;

        $categallery_add->save();

        Session::flash('success','Thêm danh mục Gallery thành công');
        return redirect()->route('admin.gallery-cate.list');
    
    }

    public function getList() {
        $data['list'] = DB::table('cate_gallery')->get();
        return view('admin.categallery.list',isset($data) ? $data : null);
    }

    public function getEdit($id) {
        $cate_edit = CateGallery::FindOrFail($id);
        $cate_list = CateGallery::where('id','<>',$id)->get();
        return view('admin.categallery.edit',['cate_edit' => $cate_edit,'cate_list' =>$cate_list]);
    }

    public function postEdit($id, Request $request) {
        $check_id = $request->sltParent;
        $this->validate($request, [
                'iptName' => 'required|unique:cate_gallery,name,'.$id.',id,parent_id,'.$check_id,
            ],
            [
                'iptName.unique' => 'Tên danh mục đã tồn tại',
                'iptName.required' => 'Chưa nhập tên danh mục',
            ]
        );
        /*
        * End Validation
        */
        $categallery_edit = CateGallery::FindOrFail($id);
  
        $categallery_edit->parent_id = $request->sltParent;
        $categallery_edit->name	 = $request->iptName;
        $categallery_edit->slug = null;
        $categallery_edit->update(['name' => $request->iptName]);      
        $categallery_edit->sort_order = $request->iptOrder;

        $categallery_edit->save();

        Session::flash('success','Sửa danh mục Thành công !');
        return redirect()->route('admin.gallery-cate.list');   
    }

    public function getDelete($id) {
        // Kiểm tra xem có danh mục con hay không ? nếu có không được xóa
        $chid_cate = DB::table('cate_gallery')->where('parent_id',$id)->count();
        if ($chid_cate > 0) {
        	Session::flash('error','Danh mục có chứa danh mục con, bạn cần xóa danh mục con trước !');
        	return back();
        } else 
        {
        	// Kiểm tra xem nó có gallery hay không
        	$gallery = DB::table('gallery')->where('g_cate_id',$id)->count();
        	if ($gallery > 0) {
        		Session::flash('danger','Danh mục có chứa gallery ảnh, bạn không được phép xóa !');
        		return back();
        	} else 
        	{
        		DB::table('cate_gallery')->where('id',$id)->delete();
        		Session::flash('success','Xóa danh mục thành công !');
        		return back();
        	}
        }
    }
}
