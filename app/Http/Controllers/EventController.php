<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Session;
use File;

class EventController extends Controller
{

public function getAdd() {
    return view('admin.events.add');
}
public function postAdd(Request $request) {
    $this->validate($request, [
        'iptTitle' => 'required',
        'iptImage' => 'image',
        'txtIntro' => 'required'
    ],
    [
        'iptTitle.required' => 'Chưa nhập tên',
        'iptImage.image'    => 'Chọn ảnh không hợp lệ',
        'txtIntro.required'  => 'Chưa nhập nội dung',
    ]
);  


    $event             = new \App\Event;

    $event->title     = $request->iptTitle;
    $event->intro     = $request->txtIntro;

    	// Lưu ảnh vào folder upload
    if ($request->hasFile('iptImage')) {
        $file = $request->file('iptImage');
        $file_name = $file->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
        $file_name = str_slug($file_name);
        $file_extension = $file->getClientOriginalExtension();
        $picture = $file_name.'.'.$file_extension;
        $des_path = public_path().'/upload/filemanager/event/';
        while (file_exists('upload/filemanager/event/'.$picture)) {
            $picture = str_random(5)."_".$picture;
        }
            // Chuyển ảnh vào folder và đưa về size 600x600
        $file->move($des_path, $picture);
        $img_resize = Image::make('upload/filemanager/event/'.$picture);
        $img_resize->resize(800,500);
        $img_resize->save();
            // lưu vào bảng tour
        $event->image = $picture;
    }

    	// Lưu vào database
    $event->save();

    Session::flash('success','Thêm Sự kiện thành công !');
    return redirect()->route('admin.event.list');
}
public function getList() {
   $events = \App\Event::orderBy('id','desc')->get();

   return view('admin.events.list', compact('events'));
}
public function getDelete($id) {

    $event = \App\Event::FindOrFail($id);
    
		// Xóa Ảnh đại diện
    File::delete('upload/filemanager/event/'.$event->image);
    $event->delete($id);

    Session::flash('success','Xóa bài viết thành công !');
    return redirect()->route('admin.event.list');
}
public function getEdit ($id) {

   $event = \App\Event::find($id);
   // dd($event);

   return view('admin.events.edit', ['event' => $event]);
}

public function postEdit (Request $request, $id) {
    $event = \App\Event::find($id);
    $this->validate($request, [
        'iptTitle' => 'required',
        'txtIntro'  => 'required',  
        'iptImage' => 'image',
    ],
    [
        'iptTitle.required' => 'Chưa nhập tên',
        'txtBody.required'  => 'Chưa nhập nội dung', 
        'iptImage.image'     => 'Ảnh chọn không hợp lệ',
    ]
);

    $event->title = $request->iptTitle;
    $event->intro   = $request->txtIntro;

    $img_old = 'upload/filemanager/event/'.$event->image;
    	// Lưu ảnh vào folder upload
		// Lưu ảnh vào folder upload
    if ($request->hasFile('iptImage')) {
        $file = $request->file('iptImage');
        $file_name = $file->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
        $file_name = str_slug($file_name);
        $file_extension = $file->getClientOriginalExtension();
        $picture = $file_name.'.'.$file_extension;
        $des_path = public_path().'/upload/filemanager/event/';
        while (file_exists('upload/filemanager/event/'.$picture)) {
            $picture = str_random(5)."_".$picture;
        }
            // Chuyển ảnh vào folder và đưa về size 600x600
        $file->move($des_path, $picture);
        $img_resize = Image::make('upload/filemanager/event/'.$picture);
        $img_resize->resize(800,500);
        $img_resize->save();
            // Xóa ảnh cũ
        if (file_exists($img_old)) {
            File::delete($img_old);
        }
            // lưu vào bảng tour
        $event->image = $picture;
    }

    // Lưu vào database
    $event->save();

    Session::flash('success','Sửa bài Sự kiện thành công !');
    return redirect()->route('admin.event.list');

}
public function deleteAll(Request $request)
{
    $ids = $request->ids;
    $ids = explode(",",$ids);
    foreach ($ids as $key => $value) {
        $article = DB::table('article')->where('id', $value)->first();
        $p_img = 'upload/filemanager/article/' . $article->image;
        if (file_exists($p_img)) {
            File::delete($p_img);
        }
        DB::table('article')->where('id', $value)->delete();
    }
    return response()->json(['success'=>"Xóa Bài viết thành công."]);
}

public function saveBody($content) 
{
    $body = new \DOMDocument();
    libxml_use_internal_errors(true);
    $body->loadhtml('<?xml encoding="utf-8" ?>' . $content);
    libxml_clear_errors();
    $imgs = $body->getElementsByTagName('img');
    $i = 0;
    for ($i; $i < $imgs->length; $i++) {
        $attr = $imgs->item($i)->getAttribute('src');
        $compare = substr_count($attr,'http',0,5);
        if ($compare == 1) {
            $filename = basename($attr);
            if (file_exists('upload/get_images/'.$filename)) {
                $filename = str_random(5)."_".$filename;
            }
            Image::make($attr)->save('upload/get_images/'.$filename);
            $imgs->item($i)->setAttribute('src','/upload/get_images/'.$filename);
            $body->saveHTML($imgs->item($i));
        }

    }
    $body = $body->saveHTML();
    return $body;
}
}
