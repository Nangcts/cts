<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Notifications\AdminNotification;
use App\User;
use Session;
use File;
use Image;
use App\Category;


class CategoryController extends Controller
{
	public function __construct() { 
	}
	public function getNested ()
	{
		$categories = Category::orderBy('sort_order','asc')->get();
		return view('admin.category.category',['categories' => $categories]);
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
				DB::table('categories')->where('id',$row['id'])->update(['parent_id' => $row['parentID'], 'sort_order' => $i]);
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

	public function getEditCategory ($id) {
		$categories = Category::orderBy('sort_order','asc')->get();
		$category = Category::find($id);

        // dd($catalog_edit);

		return view('admin.category.edit',['category' => $category, 'categories' => $categories]);
	}
	public function postEditCategory ($id, Request $request) {
		$this->validate($request, 
			[
				'iptName' => 'required|unique:article,title|unique:cate,name|unique:products,name|unique:categories,name,'.$id,
				'iptCustomSlug' => 'unique:cate,slug|unique:article,slug|unique:products,slug|unique:catalog,slug|unique:categories,slug,'.$id,
			],
			[
				'iptName.required' => 'Chưa nhập tên danh mục',
				'iptName.unique' => 'Tên danh mục đã tồn tại trên hệ thống',
				'iptCustomSlug.unique' => 'Đường dẫn đã tồn tại',
			]
		);

		$category = Category::FindOrFail($id);

		$category->name = $request->iptName;
		$category->long_des = $request->txtDes;
		$category->icon = $request->iptIcon;

		if (($request->customUrl) == 'on') {
			$category->slug = $request->iptCustomSlug;
			$category->custom_url = 1;
		} else {
			$category->slug = null;
			$category->update(['name' => $request->iptName]); 
			$category->custom_url = 0;
		}
		$category->parent_id = $request->sltParent;
		// $catalog_edit->type = $request->rdoType;
		// $catalog_edit->show_index = $request->radioShowIndex;
		// $catalog_edit->keywords = $request->iptKeywords;
		// $catalog_edit->des = $request->txtDes;

		$category->save();

		// $action_name = __FUNCTION__;
		// User::find(1)->notify(new AdminNotification($category, $action_name));

		Session::flash('success','Sửa phân loại thành công !');
		return redirect()->route('admin.category.getNested');
	}
	public function getDeleteCategory ($id) {
        // kiểm tra xem có danh mục con hay không
		$check_chid = DB::table('categories')->where('parent_id',$id)->count();
		if ($check_chid > 0) {
			Session::flash('error','Phân loại có chứa phân loại con, bạn không thể xóa !');
			return redirect()->route('admin.category.getNested');
		} else {
            // Kiểm tra xem có Sản phẩm trong danh mục không
			$check_product = Category::find($id)->products()->count();
			if ($check_product > 0) {
				Session::flash('error','Không thể xóa phân loại này !');
				return redirect()->route('admin.category.getNested');
			} else {
				DB::table('categories')->where('id',$id)->delete();
				Session::flash('success','Xóa phân loại thành công !');
				return redirect()->route('admin.category.getNested');
			}

		}
	}
	public function getAddCatalog () {
		$catalogs = get_all_categories();
		return view('admin.catalog.add',['catalog_list' => $kiot_retailer]);
	}

	public function postAddCategory (Request $request) {

		$this->validate($request, 
			[
				'iptName' => 'required|unique:article,title|unique:products,name|unique:categories,name|unique:cate,name',
				'iptCustomSlug' => 'unique:cate,slug|unique:article,slug|unique:products,slug|unique:categories,name',
			],
			[
				'iptName.required' => 'Bạn chưa nhập tên danh mục',
				'iptName.unique' => 'Tên danh mục đã tồn tại trên hệ thống',
				'iptCustomSlug.unique' => 'Đường dẫn đã tồn tại',
			]
		);
		$category = new Category;

		$category->name = $request->iptName;
		$category->icon = $request->iptIcon;
		$category->parent_id = $request->sltParent;
		$category->long_des = $request->txtDes;
		// $catalog->type = $request->rdoType;
		// $catalog->show_index = $request->radioShowIndex;
		// $catalog->keywords = $request->iptKeywords;
		// $catalog->des = $request->txtDes;

		$category->save();

		if (($request->customUrl) == 'on') { 
			$category->slug = $request->iptCustomSlug;
			$category->custom_url = 1;
		} else {
			$category->slug = null;
			$category->update(['name' => $request->iptName]);
		}
		$category->save();

		// $action_name = __FUNCTION__;
		// User::find(1)->notify(new AdminNotification($catalog, $action_name));

		Session::flash('success','Thêm phân loại thành công !');
		return redirect()->route('admin.category.getNested');
	}
	public function sortOfferProducts($category_id = null)
{

    $categories = Category::whereNull('parent_id')
                          ->with(['children' => function ($q) {
                              $q->orderBy('sort_order', 'asc');
                          }])
                          ->orderBy('sort_order', 'asc')
                          ->get();

    $products = collect();
    if ($category_id) {
        $products = Product::where('catalog_id', $category_id)
            ->orderBy('sort_offer', 'asc')
            ->get();
    }

    return view('admin.product.sort_offer_products', compact('categories', 'products', 'category_id'));
}
public function index()
{
    $categories = Category::all();

    return view('admin.product.sort_offer_products', compact('categories'));
}

}