<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Brands;
use DB;
use Session;
use Image;
use File;

class BrandsController extends Controller
{
	public function __construct() { 
        if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
            error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
        }
    }
	public function getAdd ()
	{
		return view('admin.brands.add');
	}

	public function postAdd (Request $request)
	{
		$this->validate($request, [
			'iptName' => 'required|unique:catalog,name|unique:cate,name|unique:article,title|unique:products,name',
		],
		[
			'iptName.required' => 'Bạn chưa nhập tên hãng sản xuất',
			'iptName.unique'    => 'Tên hãng sản xuất đã tồn tại',
		]
	);

		$brand = new Brands;
		$brand->name = $request->iptName;      
		$brand->sort_order = $request->iptOrderAdd;
		$brand->keywords = $request->iptKeywords;
		$brand->des = $request->txtDes;
		if ($request->hasFile('iptImage')) {
			$file = $request->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/brands/';
			while (file_exists('public/upload/brands/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			$file->move($des_path, $picture);
			$brand->logo = $picture;
			$img_resize = Image::make('public/upload/brands/'.$picture);
			$img_resize->resize(460,460);
			$img_resize->save();
		}
		$brand->save();
		Session::flash('success','Thêm hãng thành công !');
		return redirect()->route('admin.brand.list');
	}

	public function getEdit ($id)
	{
		$brand = Brands::find($id);
		return view('admin.brands.edit', compact('brand'));
	}

	public function postEdit (Request $request, $id)
	{
		$this->validate($request, [
			'iptName' => 'required|unique:catalog,name|unique:cate,name|unique:article,title|unique:products,name|unique:brands,name,'.$id,
		],
		[
			'iptName.required' => 'Bạn chưa nhập tên hãng',
			'iptName.unique'    => 'Tên hãng đã tồn tại',
		]
	);

		$brand = Brands::find($id);
		$brand->slug = null;
		$brand->update(['name' => $request->iptName]);       
		$brand->sort_order = $request->iptOrderAdd;
		$brand->keywords = $request->iptKeywords;
		$brand->des = $request->txtDes;
		if ($request->hasFile('iptImage')) {
			// delete old logo
			$old_logo = 'public/upload/brands/' . $brand->logo;
			if (file_exists($old_logo)) {
				File::delete($old_logo);
			}
			// add new logo
			$file = $request->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/brands/';
			while (file_exists('public/upload/brands/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			$file->move($des_path, $picture);
			$brand->logo = $picture;
			$img_resize = Image::make('public/upload/brands/'.$picture);
			$img_resize->resize(460,460);
			$img_resize->save();
		}
		$brand->save();
		Session::flash('success','Sửa hãng sản xuất thành công !');
		return redirect()->route('admin.brand.list');
	}
	public function getList ()
	{
		$brands = Brands::all();
		return view('admin.brands.list', compact('brands'));
	}

	public function getDelete ($id)
	{

		$brand = Brands::find($id);
		if (isset($brand)) {
			$products = DB::table('products')->where('brand_id', $id)->count();
			if ($products > 0) {
				Session::flash('error','Không thể xóa hãng sx này do có sản phẩm trong hãng !');
				return redirect()->route('admin.brand.list');
			} else {
				$brand_logo = 'public/upload/brands/' . $brand->logo;
				if (file_exists($brand_logo)) {
					File::delete($brand_logo);
				}
				$brand->delete();
				Session::flash('success','Xóa hãng sản xuất thành công !');
				return redirect()->route('admin.brand.list');
			}
		} else {
			return redirect('/');
		}
	}
}
