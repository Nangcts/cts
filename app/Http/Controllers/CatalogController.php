<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Catalog;
use DB;
use App\Notifications\AdminNotification;
use App\User;
use Session;
use File;
use Image;

class CatalogController extends Controller
{
    public function __construct() { 
    }
    public function getNested ()
    {
        $catalog = Catalog::orderBy('sort_order','asc')->get();
        return view('admin.catalog.catalog',['catalog' => $catalog]);
    }

    public function postNested (Request $r)
    {
        if ($r->ajax()) {
            $data = $r->get('dataString');
            $data = json_decode($data['data']);
            $readbleArray = $this->parseJsonArray($data);
            $i=0;
            foreach($readbleArray as $row){
                $i++;
                DB::table('catalog')->where('id',$row['id'])->update(['parent_id' => $row['parentID'], 'sort_order' => $i]);
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

    public function getEditCatalog ($id) {
        $catalogs = Catalog::orderBy('sort_order','asc')->get();
        $catalog_edit = Catalog::find($id);

        // dd($catalog_edit);

        return view('admin.catalog.edit',['catalog_edit' => $catalog_edit, 'catalogs' => $catalogs]);
    }
    public function postEditCatalog ($id, Request $request) {
        $check_id = $request->sltParent;
        $this->validate($request, 
            [
                'iptName' => 'required',
                'iptCustomSlug' => 'unique:cate,slug|unique:article,slug|unique:products,slug|unique:catalog,slug,'.$id,
            ],
            [
                'iptName.required' => 'Chưa nhập tên danh mục',
                'iptCustomSlug.unique' => 'Đường dẫn đã tồn tại',
            ]
        );
        
        $catalog_edit = Catalog::FindOrFail($id);

        $catalog_edit->name = $request->iptName;

        if (($request->customUrl) == 'on') {
            $catalog_edit->slug = $request->iptCustomSlug;
            $catalog_edit->custom_url = 1;
        } else {
            $catalog_edit->slug = null;
            $catalog_edit->update(['name' => $request->iptName]); 
            $catalog_edit->custom_url = 0;
        }
        $catalog_edit->parent_id = $request->sltParent;
        $catalog_edit->type = $request->rdoType;
        $catalog_edit->show_index = $request->radioShowIndex;
        $catalog_edit->keywords = $request->iptKeywords;
        $catalog_edit->des = $request->txtDes;
        $old_img = '/upload/filemanager/catalog/'.$catalog_edit->image;
        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = public_path().'/upload/filemanager/catalog/';
            while (file_exists('upload/filemanager/catalog/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $catalog_edit->image = $picture;
            $file->move($des_path, $picture);
            $image = Image::make('upload/filemanager/catalog/' . $picture);
            $image->resize(175,175)->save();
            if(file_exists($old_img)) {
                File::delete($old_img);
            }
        }

        $catalog_edit->save();
        
        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($catalog_edit, $action_name));

        Session::flash('success','Sửa danh mục thành công !');
        return redirect()->route('admin.getNested');
    }
    public function getDeleteCatalog ($id) {
        // kiểm tra xem có danh mục con hay không
        $check_chid = DB::table('catalog')->where('parent_id',$id)->count();
        if ($check_chid > 0) {
            Session::flash('error','Danh mục có chứa danh mục con, bạn không thể xóa !');
            return redirect()->route('admin.getNested');
        } else {
            // Kiểm tra xem có Sản phẩm trong danh mục không
            $check_product = DB::table('products')->where('catalog_id',$id)->count();
            if ($check_product > 0) {
                Session::flash('error','Không thể xóa danh mục này !');
                return redirect()->route('admin.getNested');
            } else {
                DB::table('catalog')->where('id',$id)->delete();
                Session::flash('success','Xóa danh mục thành công !');
                return redirect()->route('admin.getNested');
            }

        }
    }
    public function getAddCatalog () {
        $catalogs = get_all_categories();
        return view('admin.catalog.add',['catalog_list' => $kiot_retailer]);
    }

    public function postAddCatalog (Request $request) {

        $this->validate($request, 
            [
                'iptName' => 'required|unique:article,slug|unique:products,slug|unique:catalog,slug|unique:cate,name',
                'iptCustomSlug' => 'unique:cate,slug|unique:article,slug|unique:products,slug|unique:catalog,slug',
            ],
            [
                'iptName.required' => 'Bạn chưa nhập tên danh mục',
                'iptName.unique' => 'Tên danh mục đã tồn tại',
                'iptCustomSlug.unique' => 'Đường dẫn đã tồn tại',
            ]
        );
        $catalog = new Catalog;

        $catalog->name = $request->iptName;
        $catalog->parent_id = $request->sltParent;
        $catalog->type = $request->rdoType;
        $catalog->show_index = $request->radioShowIndex;
        $catalog->keywords = $request->iptKeywords;
        $catalog->des = $request->txtDes;

        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = public_path().'/upload/filemanager/catalog/';
            while (file_exists('upload/filemanager/catalog/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $catalog->image = $picture;
            $file->move($des_path, $picture);
            $image = Image::make('upload/filemanager/catalog/' . $picture);
            $image->resize(175,175)->save();
        }

        $catalog->save();

        if (($request->customUrl) == 'on') { 
            $catalog->slug = $request->iptCustomSlug;
            $catalog->custom_url = 1;
        } else {
            $catalog->slug = null;
            $catalog->update(['name' => $request->iptName]);
        }
        $catalog->save();

        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($catalog, $action_name));
        
        Session::flash('success','Thêm danh mục thành công !');
        return redirect()->route('admin.getNested');
    }

    public function getTerm ($id) {
        $term = Catalog::FindOrFail($id);
        $term_product = DB::table('products')->where('catalog_id',$id)->get();
        if (isset($term) && isset($term_product)) {
            return view('admin.catalog.term',['term' => $term,'term_product' => $term_product]);
        } else {
            Session::flash('danger','Danh mục không tồn tại');
            return back();
        }
    }
}
