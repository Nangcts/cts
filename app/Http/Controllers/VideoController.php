<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB, Session;

use App\Video;

use App\CateVideo;

use File;

class VideoController extends Controller
{
	public function createVideo() {
		return view('admin.video.create');
	}
	public function storeVideo (Request $request)
	{
		$this->validate($request, 
			[
				'iptTitle' => 'required|unique:categories,name|unique:products,name|unique:cate,name|unique:article,title|unique:videos,title',
				'iptLink' => 'required',
			],
			[
				'iptTitle.required' => 'Chưa nhập tiêu đề Video',
				'iptTitle.unique' => 'Vui lòng nhập tiêu đề Video khác',
				'iptLink.required' => 'Chưa nhập link video',
			]
		);

		$video = new \App\Video;

		$video->title = $request->iptTitle;
		$video->link = $request->iptLink;
		$video->seo_title = $request->iptSeoTitle;
		$video->seo_des = $request->txtDes;

		$video->save();

		Session::flash('success','Tạo video thành công !');
		return redirect()->route('listVideo');
	}

	public function listVideo ()
	{
		$videos = \App\Video::orderBy('created_at','desc')->get();

		return view('admin.video.list', compact('videos'));
	}

	public function editVideo (Request $request,  $id)
	{
		$video = \App\Video::findOrFail($id);
		return view('admin.video.edit', compact('video'));
	}

	public function updateVideo (Request $request, $id)
	{
		$this->validate($request, 
			[
				'iptTitle' => 'required|unique:categories,name|unique:products,name|unique:cate,name|unique:article,title|unique:videos,title,'.$id,
				'iptLink' => 'required',
			],
			[
				'iptTitle.required' => 'Chưa nhập tiêu đề Video',
				'iptTitle.unique' => 'Vui lòng nhập tiêu đề Video khác',
				'iptLink.required' => 'Chưa nhập link video',
			]
		);

		$video = \App\Video::findOrFail($id);

		$video->title = $request->iptTitle;
		$video->slug = null;
		$video->update(['title' => $request->iptTitle]); 
		$video->link = $request->iptLink;
		$video->seo_title = $request->iptSeoTitle;
		$video->seo_des = $request->txtDes;

		$video->save();

		Session::flash('success','Cập nhật video thành công !');
		return redirect()->route('listVideo');
	}
}
