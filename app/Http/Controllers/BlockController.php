<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Blocks;
use Session;
use File;

class BlockController extends Controller
{
    public function getAdd () {

    	return view('admin.block_html.add');

    }
    public function postAdd(Request $request) {
    	$this->validate($request, 
    	[
    		'iptTitle' => 'required|unique:blocks,title',
    		'txtBody' => 'required'
    	],
    	[
            'iptTitle.required' => 'Chưa nhập tiêu đều khối',
            'iptTitle.unique'   => 'Tên khối đã tồn tại',
            'txtBody.required'  => 'Chưa nhập nội dung khối' 
    	]
    	);

    	$block_add = new Blocks;

        $block_add->title = $request->iptTitle;
        $block_add->link = $request->iptLink;
    	$block_add->body = $request->txtBody;

        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = public_path().'/upload/blocks/';
            while (file_exists('upload/blocks/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $file->move($des_path, $picture);
            $block_add->image = $picture;

        }

    	$block_add->save();
        Session::flash('success','Thêm mới khối thành công !');
        return redirect()->route('admin.block.list');


    }
    public function getList() {

    	$block_list = Blocks::orderBy('id','desc')->get()->toArray();
    	return view('admin.block_html.list', ['block' => $block_list]);
    }

    public function getEdit(Request $request, $id) {

    	$block_edit = Blocks::find($id);
    	return view('admin.block_html.edit', ['block' => $block_edit]);
    }

    public function postEdit(Request $request, $id) {
        $block = Blocks::find($id);
        $this->validate($request,[
            'iptTitle' => 'unique:blocks,title,'.$block['id'],
            'iptTitle' => 'required',
            'txtBody' => 'required',
        ],
        [
            'iptTitle.required' => 'Chưa nhập tiêu đều khối',
            'iptTitle.unique' => 'Tên khối đã tồn tại',
            'txtBody.required' => 'Chưa nhập nội dung khối' ,
        ]
        );
        

        $block->title = $request->iptTitle;
        $block->body = $request->txtBody;
        $block->link = $request->iptLink;


        $old_img = 'upload/blocks/' . $block->image;
        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = public_path().'/upload/blocks/';
            while (file_exists('upload/blocks/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $file->move($des_path, $picture);
            $block->image = $picture;

            // Xoa Icon cu
            if (file_exists($old_img)) {
                File::delete($old_img);
            }
        }

        $block->save();
        Session::flash('success','Sửa khối thành công !');
        return redirect($request->iptPre);
    }
    public function getDelete($id)
    {
        $block = Blocks::find($id);
        $img = 'upload/block/' . $block->image;
        if (file_exists($img)) {
            File::delete($img);
        }

        if (isset($block)) {
            $block->delete();
        }

        Session::flash('success','Xóa khối thành công!');
        return redirect()->route('admin.block.list');
    }
}
