<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cate;
use Session;
use DB;
use Image;
use File;
class CateController extends Controller
{
    public function getNested ()
    {
        $cate = Cate::orderBy('sort_order','ASC')->get();
        return view('admin.cate.cate',['cate' => $cate]);
    }

    public function postNested (Request $r)
    {
        if ($r->ajax()) {
            // $data = $r->get('dataString[data]');
            $data = $r->get('dataString');
            $data = json_decode($data['data']);
            $readbleArray = $this->parseJsonArray($data);
            $i=0;
            foreach($readbleArray as $row){
                $i++;
                DB::table('cate')->where('id',$row['id'])->update(['parent_id' => $row['parentID'], 'sort_order' => $i]);
            }
        }
    }
    public function parseJsonArray($jsonArray, $parentID = 0) 
    {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }
            $return[] = array('id' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }
    public function getList() {
    	$cate_list = Cate::orderBy('sort_order','ASC')->get();
    	return view('admin.cate.list',['cate_list'=>$cate_list]);
    }
    public function getAdd() {
        $cate_list = Cate::all();
        return view('admin.cate.add',['cate_list' => $cate_list]);   
    }
    public function postAdd(Request $request) {
        $this->validate($request, [
            'iptNameAdd' => 'required|max:255|unique:cate,name',
            'iptCustomSlug' => 'unique:cate,slug|unique:article,slug|unique:products,slug|unique:catalog,slug',      
        ],
        [
            'iptNameAdd.required' => 'Bạn chưa nhập tên danh mục',
            'iptNameAdd.unique'   => 'Tên danh mục đã tồn tại',
            'iptNameAdd.max'      => 'Tên danh mục không dài quá 255 ký tự',
            'iptCustomSlug.unique' => 'Đường dẫn này đã tồn tại',


        ]

    );        
        $Cate_add = new Cate;

        $Cate_add->slug = 'slug';
        
        $Cate_add->slug_base = 'cate';
        $Cate_add->parent_id = $request->sltParentAdd;
        $Cate_add->name = $request->iptNameAdd;
        $Cate_add->sort_order = $request->iptOrderAdd;
        $Cate_add->des = $request->txtDes;
        $Cate_add->check_menu = $request->optionsRadiosMenu;
        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = base_path().'/upload/cate/';
            while (file_exists('upload/cate/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            // Chuyển ảnh vào folder và đưa về size 600x600
            $file->move($des_path, $picture);
            //$img_resize = Image::make('upload/cate/'.$picture);
            //$img_resize->resize(270,160);
            //$img_resize->save();

            // lưu vào bảng tour
            $Cate_add->image = $picture;
        }


        $Cate_add->save();

        if (($request->customUrl) == 'on') { 
            $Cate_add->slug = $request->iptCustomSlug;
            $Cate_add->custom_url = 1;
        } else {
            $Cate_add->slug_base = 'cate-'.$Cate_add->id;
            $Cate_add->slug = null;
            $Cate_add->update(['name' => $request->iptNameAdd]);
        }

        $Cate_add->save();

        Session::flash('success','Thêm danh mục thành công !');
        return redirect()->route('admin.cate.getNested');

    }
    public function getEdit($id) {
        $cate_edit = Cate::FindOrFail($id);
        $cate_list = Cate::orderBy('sort_order','ASC')->get();
        return view('admin.cate.edit',['cate_edit' => $cate_edit,'cate_list' =>$cate_list]);
    }
    public function postEdit(Request $request,$id) {
        $this->validate($request, [
            'iptName'   => 'required|max:255|unique:cate,name,'.$id,
            'sltParent' => 'unique:cate,id,NULL,id,id,'.$id,
            'iptCustomSlug' => 'unique:catalog,slug|unique:products,slug|unique:cate,slug,'.$id,

        ],
        [
            'iptName.unique'    => 'Tên danh mục đã tồn tại',
            'iptCustomSlug.unique'    => 'Đường dẫn đã tồn tại',
            'iptName.required'  => 'Chưa nhập tên danh mục',
            'iptName.max'       => 'Tên danh mục không dài quá 255 ký tự',
            'sltParent.unique'  => 'Không thể chọn danh mục cha là chính nó',


        ]
    );
    	/*
    	* End Validation
    	*/
    	$Cate_edit = Cate::FindOrFail($id);

        if (($request->customUrl) == 'on') {
            $Cate_edit->slug = $request->iptCustomSlug;
            $Cate_edit->custom_url = 1;
        } else {
            $Cate_edit->slug_base = 'cate-'.$id;
            $Cate_edit->slug = null;
            $Cate_edit->update(['name' => $request->iptName]); 
            $Cate_edit->custom_url = 0;
        }

        $Cate_edit->name = $request->iptName;
        $Cate_edit->parent_id = $request->sltParent;
        $Cate_edit->check_menu = $request->optionsRadiosMenu;
        $Cate_edit->sort_order = $request->iptOrder;
        $Cate_edit->des = $request->txtDes;
        $img_old = 'upload/cate/'.$Cate_edit->image;

        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = base_path().'/upload/cate/';
            while (file_exists('upload/cate/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            // Chuyển ảnh vào folder và đưa về size 600x600
            $file->move($des_path, $picture);
            //$img_resize = Image::make('upload/cate/'.$picture);
            //$img_resize->resize(270,160);
            //$img_resize->save();
            // Xóa ảnh cũ
            if (file_exists($img_old)) {
                File::delete($img_old);
            }
            // lưu vào bảng tour
            $Cate_edit->image = $picture;
        }
        $Cate_edit->save();

        Session::flash('success','Sửa danh mục thành công !');
        return redirect()->route('admin.cate.getNested');	
    }
    public function getDelete($id) {
        // kiểm tra xem có danh mục con hay không
        $check_chid = DB::table('cate')->where('parent_id',$id)->count();
        if ($check_chid > 0) {
            Session::flash('error','Danh mục có chứa danh mục con, bạn không thể xóa !');
            return redirect()->route('admin.cate.list');
        } else {
            // Kiểm tra xem có bài viết trong danh mục không
            $check_article = DB::table('article')->where('cate_id',$id)->count();
            if ($check_article > 0) {
                Session::flash('error','Không thể xóa danh mục này, bạn phải xóa hết bài viết trong danh mục trước !');
                return redirect()->route('admin.cate.getNested');
            } else {
                DB::table('cate')->where('id',$id)->delete();
                Session::flash('success','Xóa danh mục thành công !');
                return redirect()->route('admin.cate.getNested');
            }

        }

    }

    public function getTerm ($id) {
        $term = Cate::FindOrFail($id);
        $term_check =Cate::all();
        $id_arr = get_all_chid($term_check,$id);
        $id_arr =  explode(",", $id_arr);

        $article = DB::table('article')->whereIn('cate_id',$id_arr)->get();
        if (isset($term) && isset($article)) {
            return view('admin.cate.term',['term' => $term,'article' => $article]);
        } else {
            Session::flash('danger','Danh mục không tồn tại');
            return back();
        }
    }    
}
