<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Slider;

use File;

class SliderController extends Controller
{
    public function getAdd()
    {
    	return view('admin.slider.add');
    }
    public function postAdd(Request $request) {
    	$this->validate($request, [

			'iptSlide' => 'required|mimes:jpeg,jpg,png,gif', 		
    	],
    	[
			'iptSlide.required' => 'Chưa chọn ảnh',
            'iptSlide.mimes' => 'File bạn chọn không hợp lệ',

		]
    	);

    	$slider = new Slider;

    	if ($request->hasFile('iptSlide')) 
    	{
    		$slide_image = $request->file('iptSlide');
    		$slide_name = $slide_image->getClientOriginalName();
    		$slide_name = pathinfo($slide_name, PATHINFO_FILENAME); 
    		$slide_name = str_slug($slide_name);

    		$slide_extension = $slide_image->getClientOriginalExtension();

            $slide_name = $slide_name.".".$slide_extension;

			while (file_exists('upload/filemanager/slider/'.$slide_name)) {
				$slide_name = str_random(4)."_".$slide_name;
			}
			$slide_image->move('upload/filemanager/slider/',$slide_name);
			$slider->slide = $slide_name;
		}
		else
		{
			$slider->slide = '';
		}
        $slider->link = $request->iptLink;
    	
    	$slider->sort_order = $request->iptOrder;

    	$slider->save();
    	return redirect()->route('admin.slider.list')->with(['flash_level'=>'success','flash_message'=>'Thêm Ảnh Slide thành công!']);

    }

    public function getEdit($id)
    {
    	$slide = Slider::find($id);

    	return view('admin.slider.edit',['slide'=>$slide]);
    } 

    public function postEdit($id, Request $request)
    {
    	$this->validate($request, [
    		'iptSlide' => 'mimes:jpg,jpeg,png',
    	], 
    	[
    		'iptSlide.mimes' => 'File bạn chọn không hợp lệ',
    	]);

    	$slide = Slider::find($id);

    	if ($request->hasFile('iptSlide')) 
    	{
    		$old_slide = "upload/filemanager/slider/".$slide->slide;

    		$slide_image = $request->file('iptSlide');
    		$slide_name = $slide_image->getClientOriginalName();
    		$slide_name = pathinfo($slide_name, PATHINFO_FILENAME); 
    		$slide_name = str_slug($slide_name);

    		$slide_extension = $slide_image->getClientOriginalExtension();

            $slide_name = $slide_name.".".$slide_extension;

			while (file_exists('upload/filemanager/slider/'.$slide_name)) {
				$slide_name = str_random(4)."_".$slide_name;
			}
			$slide_image->move('upload/filemanager/slider/',$slide_name);
			$slide->slide = $slide_name;

			// Xóa Slide cũ

			if (file_exists($old_slide)) {
				File::delete($old_slide);
			}
		}

        $slide->link = $request->iptLink;
		$slide->sort_order = $request->iptOrder;

		$slide->save();
		return redirect()->route('admin.slider.list')->with(['flash_level'=>'success','flash_message'=>'Sửa Ảnh Slide thành công!']);

    } 

    public function getList()
    {
    	$slider = Slider::all();

    	return view('admin.slider.list',['slider' => $slider]);
    } 

    public function getDelete($id) 
    {
    	$slide = Slider::findOrFail($id);

    	if (isset($slide)) {
    		$slide->delete($id);
    	}

    	// Xóa file ảnh trong folder

    	$slide_image = "upload/filemanager/slider/".$slide->slide;

    	if (isset($slide_image)) {
            if (file_exists($slide_image)) 
            {
                File::delete($slide_image);
            }
    	}

    	return redirect()->route('admin.slider.list')->with(['flash_level'=>'success','flash_message'=>'Xóa Ảnh Slide thành công!']);
    } 

}
