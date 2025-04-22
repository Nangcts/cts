<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FeedBack;
use Session;
use File;
use Image;
use App\User;
use App\Notifications\AdminNotification;

class FeedBackController extends Controller
{
	public function getAddFeedBack ()
	{
		return view('admin.feedback.add');
	}

	public function postAddFeedBack  (Request $request)
	{
		$this->validate($request, 
			[
				'iptName' => 'required',
				'iptAdress' => 'required',
				'txtContent' => 'required',
				'iptImage' => 'required|image',
			],
			[
				'iptName.required' => 'Bạn chưa nhập tên khách hàng',
				'iptAdress.required' => 'Bạn chưa nhập địa chỉ khách hàng',
				'iptImage.required' => 'Bạn chưa nhập ảnh đại diện',
				'iptImage.image' => 'Ảnh đại diện không hợp lệ',
				'txtContent.required' => 'Bạn chưa nhập nội dung phản hồi',
			]
		);

		$feedback = new FeedBack;

		$feedback->name = $request->iptName;
		$feedback->adress = $request->iptAdress;
		$feedback->content = $request->txtContent;
		$feedback->job = $request->iptJob;

		if ($request->hasFile('iptImage')) {
			$file = $request->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/filemanager/feedback/';
            // echo $des_path;
            // die();
			while (file_exists('upload/filemanager/product/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			$feedback->image = $picture;
			$file->move($des_path, $picture);
			$image = Image::make('upload/filemanager/feedback/' . $picture);
			$image->resize(120,120)->save();
		}

		$feedback->save();

		$action_name = __FUNCTION__;
		User::find(1)->notify(new AdminNotification($feedback, $action_name));

		Session::flash('success', 'Thêm FeedBack thành công !');
		return redirect()->route('admin.feedback.list');

	}

	public function getListFeedBack ()
	{
		$feedbacks = FeedBack::orderBy('id','DESC')->get();
		return view('admin.feedback.list',['feedbacks' => $feedbacks]);
	}

	public function getEditFeedBack ($id)
	{
		$feedback = FeedBack::find($id);
		return view('admin.feedback.edit',['feedback' => $feedback]);
	}

	public function postEditFeedBack (Request $request, $id)
	{
		$this->validate($request, 
			[
				'iptName' => 'required',
				'iptAdress' => 'required',
				'txtContent' => 'required',
				'iptImage' => 'image',
			],
			[
				'iptName.required' => 'Bạn chưa nhập tên khách hàng',
				'iptAdress.required' => 'Bạn chưa nhập địa chỉ khách hàng',
				'iptImage.image' => 'Ảnh đại diện không hợp lệ',
				'txtContent.required' => 'Bạn chưa nhập nội dung phản hồi',
			]
		);

		$feedback = FeedBack::find($id);

		$feedback->name = $request->iptName;
		$feedback->adress = $request->iptAdress;
		$feedback->content = $request->txtContent;
		$feedback->job = $request->iptJob;

		if ($request->hasFile('iptImage')) {
			// Xóa ảnh cũ
			$old_img = 'upload/filemanager/feedback/' . $feedback->image;
			if(file_exists($old_img)) {
				File::delete($old_img);
			}
			// Lưu ảnh mới
			$file = $request->file('iptImage');
			$file_name = $file->getClientOriginalName();
			$file_name = pathinfo($file_name, PATHINFO_FILENAME); 
			$file_name = str_slug($file_name);
			$file_extension = $file->getClientOriginalExtension();
			$picture = $file_name.'.'.$file_extension;
			$des_path = base_path().'/public/upload/filemanager/feedback/';
            // echo $des_path;
            // die();
			while (file_exists('upload/filemanager/product/'.$picture)) {
				$picture = str_random(5)."_".$picture;
			}
			$feedback->image = $picture;
			$file->move($des_path, $picture);
			$image = Image::make('upload/filemanager/feedback/' . $picture);
			$image->resize(120,120)->save();
		}

		$feedback->save();

		$action_name = __FUNCTION__;
		User::find(1)->notify(new AdminNotification($feedback, $action_name));

		Session::flash('success', 'Sửa FeedBack thành công !');
		return redirect()->route('admin.feedback.list');

	}
	public function getDeleteFeedBack ($id)
	{
		$feedback = FeedBack::find($id);
		if(isset($feedback)) {
			// Delete Customer Image
			$image = 'upload/filemanager/feedback/'.$feedback->image;
			if (file_exists($image)) {
				File::delete($image);
			}
			// Delete record in table feedback
			$feedback->delete();
			$action_name = __FUNCTION__;
			User::find(1)->notify(new AdminNotification($feedback, $action_name));

			Session::flash('success', 'Xóa FeedBack thành công !');
			return redirect()->route('admin.feedback.list');
		}
	}
}
