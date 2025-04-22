<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Config;

use File;

use Image;

use Session;

class ConfigController extends Controller
{

    public function getConfig() {
        $this->authorize('config-site');
    	$config = Config::select()->first();
    	return view('admin.config.config', ['config' => $config]);
    }

    public function postConfig(Request $request) {
        $this->authorize('config-site');
        
    	$this -> validate($request, [
            'iptSiteTitle' => 'required',
            'iptCompany'   => 'required',
            'txtKeywords'  => 'required',
            'txtDes'       => 'required',
            'iptAdress'    => 'required',
            'iptHotline'   => 'required',
            // 'iptPhone1'    => 'required',
            // 'iptPhone2'    => 'required',
            'iptEmail'     => 'required',
            // 'iptFace'      => 'required',

    	],
    	[
            'iptSiteTitle.required' => 'Bạn chưa nhập tên Website',
            'iptCompany.required'   => 'Bạn chưa nhập tên Công ty',
            'txtKeywords.required'  => 'Bạn chưa nhập từ khóa',
            'txtDes.required'       => 'Bạn chưa nhập mô tả',
            'iptHotline.required'   => 'Bạn chưa nhập số Hotline',
            // 'iptPhone1.required'    => 'Bạn chưa nhập số điện thoại bàn',
            // 'iptPhone2.required'    => 'Bạn chưa nhập số di động',
            'iptEmail.required'     => 'Chưa nhập Email',
            // 'iptFace.required'      => 'Chưa nhập địa chỉ Fanpage',
            'iptAdress.required'    => 'Bạn chưa nhập địa chỉ nhà hàng',

    	]);
    	$config = Config::find(1);

        $config->site_title    = $request->iptSiteTitle;
        $config->company_name  = $request->iptCompany;
        $config->slogan        = $request->iptSlogan;
        $config->hotline       = $request->iptHotline;
        $config->site_keywords = $request->txtKeywords;
        $config->site_des      = $request->txtDes;
        $config->adress        = $request->iptAdress;
        $config->phone        = $request->iptPhone;
        // $config->phone2        = $request->iptPhone2;
        $config->info          = $request->txtInfo;
        $config->email         = $request->iptEmail;
        $config->facebook      = $request->iptFace;
        $config->analytics      = $request->iptAnalytics;
        $config->master_tool      = $request->iptMasterTool;

        $current_logo = 'upload/filemanager/logo/'.$config->site_logo;

    	// Xử lý ảnh Logo

    	if($request->hasFile('iptLogo')) {
            // Xóa luôn ảnh logo cũ
            if (File::exists($current_logo)) {
                File::delete($current_logo);
            }  
            // Lưu ảnh mới
    		$file_logo = $request->file('iptLogo');
    		$logo_name = $file_logo->getClientOriginalName();
    		$logo_name = str_random(4).'_'.$logo_name;

			while (file_exists('upload/filemanager/logo/'.$logo_name)) {
				$logo_name = str_random(4)."_".$logo_name;
			}
			$file_logo->move('upload/filemanager/logo/',$logo_name);
			$config->site_logo = $logo_name;
    	}
        $current_banner = 'upload/filemanager/logo/'.$config->banner;
        if($request->hasFile('iptBanner')) {
            // Xóa luôn ảnh logo cũ
            if (File::exists($current_banner)) {
                File::delete($current_banner);
            }  
            // Lưu ảnh mới
            $file = $request->file('iptBanner');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = base_path().'/upload/filemanager/logo/';
            while (file_exists('upload/filemanager/logo/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            // Chuyển ảnh vào folder và đưa về size 600x600
            $file->move($des_path, $picture);
            $img_resize = Image::make('upload/filemanager/logo/'.$picture);
            // lưu vào bảng tour
            $config->banner = $picture;
        }
    	$config->save();

        Session::flash('success','Cập nhật cấu hình thành công !');
		return redirect()->route('getConfig');


    }
}
