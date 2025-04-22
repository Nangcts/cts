<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Cate;

use App\Article;

use App\Notifications\AdminNotification;

use File;

use Image;

use Session;

use Auth;

use App\User;

use Illuminate\Routing\Route;
use DB;


class ArticleController extends Controller
{
    public function getData(Request $request) {
        $cat = $request->cate;
        $url = $request->url;
        if(isset($url) && isset($cat)){
            $categories = file_get_html($url);
            foreach(array_reverse($categories->find('.bai-viet-list-item .view-content ul li')) as $post) {
                $post_url = $post->find('a.title',0)->href;
                $post_url = 'https://songkhoesongvui.vn'.$post_url;
                $data['title'] = $post->find('a.title',0)->plaintext;

                $intro = $post->find('div.mo-ta',0);
                if(isset($intro)) {
                    $data['intro'] = $post->find('div.mo-ta',0)->plaintext;
                } else {
                     $data['intro'] = null;
                }

                $image_element = $post->find('a.image img',0);

                if(isset($image_element)) {
                    $data['image'] = $post->find('a.image img',0)->src;
                    $data['image'] = preg_replace('/\?.*/', '', $data['image']);
                } else {
                    $data['image'] = null;
                }
                
                
                $post_detail = file_get_html($post_url);
                $data['body'] = $post_detail->find('.noidung',0)->innertext;
                $data['body'] = $this->saveBody($data['body']);
                
                $app_test = $this->savePost($cat, $data);
                echo 'Đã đăng bài viết '. $data['title'] .'<br />';
            }
        }

    }

    public function savePost ($cate_id, $data)
    {

        $article               = new Article;
        $article->title = $data['title'];
        $article->cate_id = $cate_id;
        $article->intro = $data['intro'];
        $article->body = $data['body'];
        
        // Xử lý ảnh sp
        if($data['image'] != null) {
            $img_name = basename($data['image']);
            while (file_exists('upload/filemanager/article/'.$img_name)) {
                $img_name = str_random(5)."_".$img_name;
            }
            Image::make($data['image'])->save('upload/filemanager/article/' . $img_name);
            $image = Image::make('upload/filemanager/article/' . $img_name);
            $article->image         = $img_name;
            $image->resize(600,400)->save('upload/filemanager/article/'. $img_name);
            // End xử lý ảnh
        } else {
            $article->image = null;
        }
        

        $article->save();
    }
    public function getArticle ()
    {
        $articles = DB::table('art')->orderby('id','asc')->get();
        foreach ($articles as $key => $value) {
            $article = new Article;
            $article->title = $value->title;
            $article->image = $value->image;
            $article->slug = $value->slug;
            $article->slug_base = $value->slug_base;
            $article->intro = $value->intro;
            $article->body = $value->body;
            $article->cate_id = 89;
            $article->save();
        }
        return "ök";
    }
    public function getAddArticle() {
        $this->authorize('create-article');
        $cate_list = Cate::all();
        return view('admin.article.add',['cate_list'=>$cate_list]);
    }
    public function postAddArticle(Request $request) {
        $this->authorize('create-article');
        $this->validate($request, [
            'sltcate'  => 'required',
            'iptTitle' => 'required',
            'iptImage' => 'image',
            'txtBody'  => 'required',
            'iptCustomSlug' => 'unique:article,slug|unique:cate,slug|unique:catalog,slug|unique:products,slug',	
        ],
        [
            'sltcate.required'  => 'Chưa chọn danh mục',
            'iptTitle.required' => 'Chưa nhập tên',
            'iptImage.image'    => 'Chọn ảnh không hợp lệ',
            'txtBody.required'  => 'Chưa nhập nội dung',
            'iptCustomSlug.unique' => 'Đường dẫn này đã tồn tại',
        ]
    );  

        $article_add             = new Article;

        $article_add->slug_base = 'temp';

        $article_add->cate_id   = $request->sltcate;
        $article_add->title     = $request->iptTitle;
        $article_add->intro     = $request->txtIntro;
        $article_add->body      = $request->txtBody;
        $article_add->video      = $request->iptVideo;
    // Seo config
        $article_add->seo_title = $request->iptSeoTitle;
        $article_add->keywords  = $request->txtKeywords;
        $article_add->des       = $request->txtDes;
        $article_add->user_id = auth()->user()->id;
    	// Lưu ảnh vào folder upload
        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = base_path().'/public/upload/filemanager/article/';
            while (file_exists('upload/filemanager/article/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            // Chuyển ảnh vào folder và đưa về size 600x600
            $file->move($des_path, $picture);
            $img_resize = Image::make('upload/filemanager/article/'.$picture);
            $img_resize->resize(620,350);
            $img_resize->save();
            // lưu vào bảng tour
            $article_add->image = $picture;
        }

    	// Lưu vào database
        $article_add->save();
        if (($request->customUrl) == 'on') { 
            $article_add->slug = $request->iptCustomSlug;
            $article_add->custom_url = 1;
        } else {
            $article_add->slug_base = '-pa'.$article_add->id;
            $article_add->slug = null;
            $article_add->update(['title' => $request->iptTitle]);
        }
    // Cập nhật bài viết liên quan
        $article_add->products()->attach($request->sltProductReferences);

        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($article_add, $action_name));

        Session::flash('success','Thêm bài viết thành công !');
        return redirect()->route('admin.article.list');
    }
    public function getListArticle() {
       $article_list = Article::orderBy('id','desc')->get();
       return view('admin.article.list', ['article_list'=>$article_list]);
   }
   public function getDeleteArticle($id) {

    $this->authorize('delete-article');
    $article_delete = Article::FindOrFail($id);
    $article_delete->delete($id);
		// Xóa Ảnh đại diện
    File::delete('public/upload/article/'.$article_delete->image);

    $action_name = __FUNCTION__;
    User::find(1)->notify(new AdminNotification($article_delete, $action_name));
    Session::flash('success','Xóa bài viết thành công !');
    return redirect()->route('admin.article.list');
}
public function getEditArticle ($id) {

   $article = Article::find($id);
   $this->authorize('update',$article);
   $product_id = [];
   foreach ($article->products as $product) {
    $product_id[] = $product->pivot->product_id;
}
$cate_list = Cate::all();
return view('admin.article.edit', ['article' => $article,'cate_list' => $cate_list, 'product_id' => $product_id]);
}

public function postEditArticle (Request $request, $id) {
    $this->authorize('update-article');

    $article_edit = Article::find($id);
    $this->validate($request, [
        'sltcate'  => 'required',
        'iptTitle' => 'required',
        'txtBody'  => 'required',  
        'iptImage' => 'image',
        'iptCustomSlug' => 'unique:cate,slug|unique:catalog,slug|unique:products,slug|unique:article,slug,'.$id,  

    ],
    [
        'sltcate.required'  => 'Chưa chọn danh mục',
        'iptTitle.required' => 'Chưa nhập tên',
        'txtBody.required'  => 'Chưa nhập nội dung', 
        'iptTags.required'  => 'Chưa gắn thẻ Tags', 
        'iptTitle.max' => 'Tiêu đề tối đa 255 ký tự',
        'iptMenuTitle.required' => 'Chưa nhập tiêu đề trên Menu',
        'iptImage.image'     => 'Ảnh chọn không hợp lệ',
        'iptCustomSlug.unique' => 'Đường dẫn này đã tồn tại',
    ]
);

    $article_edit->title = $request->iptTitle;

    if (($request->customUrl) == 'on') {
        $article_edit->slug = $request->iptCustomSlug;
        $article_edit->custom_url = 1;
    } else {
        $article_edit->slug_base = '-pa'.$id;
        $article_edit->slug = null;
        $article_edit->update(['title' => $request->iptTitle]); 
        $article_edit->custom_url = 0;
    }

    $article_edit->cate_id = $request->sltcate;
    $article_edit->intro   = $request->txtIntro;
    $article_edit->body    = $request->txtBody;
    $article_edit->video    = $request->iptVideo;

    $article_edit->seo_title = $request->iptSeoTitle;
    $article_edit->keywords  = $request->txtKeywords;
    $article_edit->des       = $request->txtDes;

    $article_edit->user_id  = auth()->user()->id;
    $img_old = 'upload/filemanager/article/'.$article_edit->image;
    	// Lưu ảnh vào folder upload
		// Lưu ảnh vào folder upload
    if ($request->hasFile('iptImage')) {
        $file = $request->file('iptImage');
        $file_name = $file->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
        $file_name = str_slug($file_name);
        $file_extension = $file->getClientOriginalExtension();
        $picture = $file_name.'.'.$file_extension;
        $des_path = base_path().'/public/upload/filemanager/article/';
        while (file_exists('upload/filemanager/article/'.$picture)) {
            $picture = str_random(5)."_".$picture;
        }
            // Chuyển ảnh vào folder và đưa về size 600x600
        $file->move($des_path, $picture);
        $img_resize = Image::make('upload/filemanager/article/'.$picture);
        $img_resize->resize(620,350);
        $img_resize->save();
            // Xóa ảnh cũ
        if (file_exists($img_old)) {
            File::delete($img_old);
        }
            // lưu vào bảng tour
        $article_edit->image = $picture;
    }
    // Sản phẩm liên quan
    $article_edit->products()->sync($request->sltProductReferences);

    // Lưu vào database
    $article_edit->save();;
    // end tags
    $article_edit->save();
    $action_name = __FUNCTION__;
    User::find(1)->notify(new AdminNotification($article_edit, $action_name));
    Session::flash('success','Sửa bài viết thành công !');
    return redirect()->route('admin.article.list');

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
            if (file_exists('upload/filemanager/get_images/'.$filename)) {
                $filename = str_random(5)."_".$filename;
            }
            Image::make($attr)->save('upload/filemanager/get_images/'.$filename);
            $imgs->item($i)->setAttribute('src','/upload/filemanager/get_images/'.$filename);
            $body->saveHTML($imgs->item($i));
        }

    }
    $body = $body->saveHTML();
    return $body;
}
}
