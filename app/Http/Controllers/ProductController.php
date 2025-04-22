<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Helpers\ImageRepository;
use App\Product;
use App\Catalog;
use DB;
use App\Notifications\AdminNotification;
use Image;
use File,Session;
use App\ProductImage;
use Validator;
use GuzzleHttp\Client;
use App\User;
use App\Product_Images;

class ProductController extends Controller
{
    public function getAddProduct() 
    {
        $this->authorize('create-product');
        $categories = \App\Category::where('parent_id',0)->orderBy('sort_order','asc')->get();
        // dd($categories);
        $first_product = Product::orderBy('created_at','desc')->first();
        if($first_product) {
            $first_product_id = $first_product->id + 1000;
        } else {
            $first_product_id = 0;
        }
        return view('admin.product.add',compact('categories','first_product_id'));
    }
    
     public function getAllProductsCategory ($category_id)
    {
        $term_check = \App\Category::all();
        $id_arr = get_all_chid($term_check,$category_id);
        $id_arr =  explode(",", $id_arr);
        $all_products = new \Illuminate\Database\Eloquent\Collection;
        foreach ($id_arr as $key => $value) {
            $products = \App\Category::find($value)->products()->orderby('sort_order_1','asc')->get();
            $all_products = $all_products->merge($products);
        }
        
        $products = $all_products->sortBy('sort_order_1');
        return $products;
    }
    
    public function sortProductsCatalog ($id)
    {
        $sort_products = $this->getAllProductsCategory($id);

        return view('admin.product.order-catalog', compact('sort_products'));
    }

    public function reOrderCatalogProducts(Request $request) 
    {
        // return $request->get('ids');
        if ($request->ajax()) {
            $_token = $request->get('_token');
            $ids = $request->get('ids');
            if(isset($ids)) {
                $count = 1;
                foreach ($ids as $id) {
                    DB::table('products')->where('id', $id)->update(['sort_order_1' => $count]);
                    $count ++;
                }
            }
        } 
    }
    public function postAddProduct (Request $request) 
    { 
        // dd($request->sltPostReferences);
        $this->authorize('create-product');
        $this->validate($request, 
            [
                'chkCategory' => 'required',
                'iptImage'   => 'required|image',
                'iptName'    => 'required|unique:article,title|unique:cate,name|unique:categories,name|unique:products,name',
                'iptPrice'    => 'required|integer',
                'iptSalePrice'    => 'integer|nullable',
                'iptCustomSlug' => 'unique:article,slug|unique:cate,slug|unique:categories,slug|unique:products,slug',
            ],
            [
                'chkCategory.required' => 'Chưa chọn phân loại sản phẩm',
                'iptName.required'    => 'Chưa nhập tên',
                'iptName.unique'    => 'Tên đã tồn tại, vui lòng nhập tên khác',
                'iptPrice.required'    => 'Chưa nhập giá bán',
                'iptPrice.integer'    => 'Giá bán phải là số nguyên dương',
                'iptSalePrice.integer'    => 'Giá khuyến mãi phải là số nguyên dương',
                'iptImage.required'   => 'Bạn chưa nhập ảnh sản phẩm',  
                'iptImage.image'      => 'Định dạng ảnh không hợp lệ', 
                'iptCustomSlug' => 'Đường dẫn đã tồn tại trên hệ thống !',
            ]
        );
        
        $product_add               = new Product;

        $temp_id = $request->random_temp_id;
        $product_add->name         = $request->iptName;
        

        $product_add->hot         = $request->rdoHot;
        $product_add->offer         = $request->rdoOffer;
        $product_add->status       = $request->rdoStatus;
        $product_add->price        = $request->iptPrice;
        $product_add->sale_price        = $request->iptSalePrice;
        $product_add->intro        = $request->txtIntro;
        $product_add->sale_content        = $request->iptGift;
        $product_add->body         = $request->txtBody;

        if ($request->hasFile('iptImage')) {
            $file = $request->file('iptImage');
            $file_name = $file->getClientOriginalName();
            $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture = $file_name.'.'.$file_extension;
            $des_path = public_path().'/upload/filemanager/product/';
            while (file_exists('upload/filemanager/product/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $product_add->image = $picture;
            $file->move($des_path, $picture);
            $image = Image::make('upload/filemanager/product/' . $picture);
            $image->resize(600,600)->save();
            $image = Image::make('upload/filemanager/product/' . $picture);

            // Tạo ảnh Thumbnail
            $image->resize(120,120)->save('upload/filemanager/product/thumbs/'. $picture);
        }

        $product_add->seo_title   = $request->iptSeoTitle;
        $product_add->des        = $request->txtDes;

        $product_add->save();
        // Cập nhật lại Product_ID Anh chi tiet
        $detail_imgs = Product_Images::where('product_id', $temp_id)->get();
        if($detail_imgs->first()) {
            foreach ($detail_imgs as $item) {
                $detail_img = Product_Images::find($item->id);
                $detail_img->product_id = $product_add->id;
                $detail_img->save();
            }
        }
        // Lưu catalog
        $product_add->categories()->attach($request->chkCategory);

        if (($request->customUrl) == 'on') { 
            $product_add->slug = $request->iptCustomSlug;
            $product_add->custom_url = 1;
        } else {
            $product_add->slug = null;
            $product_add->update(['name' => $request->iptName]);
        }

        // Cập nhật bài viết liên quan
        $product_add->articles()->attach($request->sltPostReferences);

        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($product_add, $action_name));

        Session::flash('success', 'Thêm sản phẩm thành công !');
        return redirect()->route('admin.product.list');       
    }

    
    public function getList() 
    {

        $data = Product::orderBy('id', 'desc')->paginate(25);
        return view('admin.product.search', ['data'=>$data]);
    }

    public function searchProduct (Request $request)
    {

        $conditions = [];
        // Search with Name
        if ($request->iptName) {
            array_push($conditions, ['name','like','%'.$request->iptName.'%']);
        }

        // Search with From Date
        if ($request->iptFromDate) {
            $from_date = date("Y-m-d", strtotime($request->iptFromDate));
            array_push($conditions, ['created_at','>=',$from_date]);
        }

    // Search with To Date
        if ($request->iptToDate) {
            $to_date = date("Y-m-d", strtotime($request->iptToDate));
            array_push($conditions, ['created_at','<=',$to_date]);
        }

    // dd($conditions);
    // Search with Category
        if ($request->sltCategory) {
            $products = \App\Category::find($request->sltCategory)->products;
            $product_id = [];
            foreach ($products as $product) {
                $product_id[] = $product->id;
            }

            $query = Product::whereIn('id',$product_id);
            $query->where($conditions)->get();
        } else {
            $query = Product::where($conditions);
        }
    // Search with Sort by Point
        if ($request->sltCreated) {
            $query->orderBy('created_at', $request->sltCreated);
        } else {
            $query->orderBy('created_at','desc');
        }

        $data = $query->paginate(25);
        return view('admin.product.search', compact('data','request'));
    }

    public function getDeleteProduct($id) 
    {
        $this->authorize('delete-product');
        $product_delete = Product::FindOrFail($id);
        $p_image = 'upload/filemanager/product/'.$product_delete->image;
        $product_delete->delete();
        // Xóa ảnh
        if (file_exists($p_image)) {
            File::delete($p_image);
        }
        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($product_delete, $action_name));

        Session::flash('success','Xóa sản phẩm thành công !');
        return redirect()->route('admin.product.list');
    }

    public function getEditProduct ($id) 
    {
        $this->authorize('update-product');
        $product = Product::find($id);
        $combos = $product->combos;
        $categories = \App\Category::where('parent_id',0)->orderBy('sort_order','asc')->get();
        $article_id = [];
        foreach ($product->articles as $article) {
            $article_id[] = $article->pivot->article_id;
        }
    // dd($article_id);

        $tags = implode(',',$product->tagNames());
        $catalogs = Catalog::orderBy('sort_order','asc')->get();

        return view('admin.product.edit', ['categories' => $categories ,'product' => $product,'catalogs' => $catalogs,'tags' => $tags,'id' => $id,'article_id' => $article_id,'combos' => $combos]);
    }

    public function postEditProduct(Request $request, $id) 
    {

        $this->authorize('update-product');
        $this->validate($request, 
            [
              'chkCategory' => 'required',
              'iptName'    => 'required|unique:article,title|unique:cate,name|unique:categories,name|unique:products,name,'.$id,
              'iptPrice' => 'required|integer',
              'iptSalePrice' => 'integer|nullable',
              'iptImage' => 'image',
              'iptCustomSlug' => 'unique:article,slug|unique:cate,slug|unique:catalog,slug|unique:products,slug,'.$id,
          ],
          [
            'chkCategory.required' => 'Chưa chọn phân loại sản phẩm',
            'iptName.required' => 'Chưa nhập tên',
            'iptName.unique' => 'Tên sản phẩm đã tồn tại, vui lòng nhập tên khác',
            'iptPrice.required' => 'Chưa nhập giá',
            'chkCategory.required' => 'Chưa chọn phân loại sản phẩm',
            'iptPrice.integer' => 'Giá phải là số nguyên dương',  
            'iptSalePrice.integer' => 'Giá khuyến mãi phải là số nguyên dương',  
            'iptImage.image' => 'Định dạng ảnh không hợp lệ',
            'iptTags.required' => 'Nhập đánh dấu Tags',
            'iptCustomSlug.unique' => 'Đường dẫn đã tồn tại',
        ]
    );
        $product_edit = Product::find($id);

        $product_edit->categories()->sync($request->chkCategory);
        $product_edit->name           = $request->iptName;
        $product_edit->sale_content        = $request->iptGift;

        if (($request->customUrl) == 'on') {
            $product_edit->slug = $request->iptCustomSlug;
            $product_edit->custom_url = 1;
        } else {
            $product_edit->slug = null;
            $product_edit->update(['name' => $request->iptName]); 
            $product_edit->custom_url = 0;
        }

        $product_edit->status        = $request->rdoStatus;
        $product_edit->hot         = $request->rdoHot;   
        $product_edit->offer         = $request->rdoOffer;
        $product_edit->sale_price          = $request->iptSalePrice;
        $product_edit->price          = $request->iptPrice;
        $product_edit->intro          = $request->txtIntro;
        $product_edit->body     = $request->txtBody;
        $product_edit->seo_title = $request->iptSeoTitle;
        $product_edit->des      = $request->txtDes;     
        $product_edit->author   = 1;
        $img_old                = 'upload/filemanager/product/'.$product_edit->image;
        $thumb_old                = 'upload/filemanager/product/thumbs/'.$product_edit->image;

    // Lưu ảnh vào folder upload
        if ($request->hasFile('iptImage')) {

            $file           = $request->file('iptImage');
            $file_name      = $file->getClientOriginalName();
            $file_name      = pathinfo($file_name, PATHINFO_FILENAME); 
            $file_name      = str_slug($file_name);
            $file_extension = $file->getClientOriginalExtension();
            $picture        = $file_name.'.'.$file_extension;
            $des_path       = public_path().'/upload/filemanager/product/';
            while (file_exists('upload/filemanager/product/'.$picture)) {
                $picture = str_random(5)."_".$picture;
            }
            $file->move($des_path, $picture);
            if(file_exists($img_old)) {
                File::delete($img_old);
            }
            if(file_exists($thumb_old)) {
                File::delete($thumb_old);
            }
            $image_resize = Image::make('upload/filemanager/product/'.$picture);
            $image_resize->resize(600,600)->save();

            $image = Image::make('upload/filemanager/product/' . $picture);
            // // Tạo ảnh Thumbnail
            $image->resize(120,120)->save('upload/filemanager/product/thumbs/'. $picture);
            $product_edit->image = $picture;

        }

    // Cập nhật bài viết liên quan
        $product_edit->articles()->sync($request->sltPostReferences);
    // Lưu vào database
        $product_edit->save();

        $action_name = __FUNCTION__;
        User::find(1)->notify(new AdminNotification($product_edit, $action_name));

        Session::flash('success', 'Sửa sản phẩm thành công !');
        return redirect()->route('admin.product.list');
    }
    public function deleteImg(Request $request)
    {
        if ($request->ajax()) {
            $img_id = $request->id;
            $img_delete = Product_Images::find($img_id);
            if (isset($img_delete)) {
                $path_img = 'upload/filemanager/product/gallery/' . $img_delete->image;
                $img_delete->delete();
                if (file_exists($path_img)) {
                    File::delete($path_img);
                }
            }
        }
    }

    public function getSales ()
    {
        $sales = Product::where('sale', 1)->get();
        return view('admin.product.sales', ['sales' => $sales]);
    }

    public function getImages ($html)
    {
        $body = new \DOMDocument();
        $body->loadhtml('<?xml encoding="utf-8" ?>' . $html);
        $imgs = $body->getElementsByTagName('img');
        $i = 0;
        for ($i; $i < $imgs->length; $i++) {
            $attr = $imgs->item($i)->getAttribute('src');
            $compare = substr_count($attr,'http',0,5);
            if ($compare == 1) {
                $filename = basename($attr);
                $filename = str_slug($attr);
                if (file_exists('public/upload/get_images/'.$filename)) {
                    $filename = str_random(5)."_".$filename;
                }
                Image::make($attr)->save('public/upload/get_images/'.$filename);
                $imgs->item($i)->setAttribute('src','/public/upload/get_images/'.$filename);
                $body->saveHTML($imgs->item($i));
            }
        }
        $body = $body->saveHTML();
        return $body;
    }
    public function deleteAll(Request $request)
    {
        $this->authorize('delete-product');

        $ids = $request->ids;
        $ids = explode(",",$ids);
        foreach ($ids as $key => $value) {
            $product = DB::table('products')->where('id', $value)->first();
            $p_img = 'public/filemanager/upload/product/' . $product->image;
            if (file_exists($p_img)) {
                File::delete($p_img);
            }
            DB::table('products')->where('id', $value)->delete();
        }
        return response()->json(['success'=>"Xóa sản phẩm thành công."]);
    }
    public function setimage ($image,$img_name, $path,$img_root, $width, $height)
    {
        $img_width = $image->width();
        $img_height = $image->height();
        $check = $img_width/$img_height;
        // nếu vượt chiều cao
        if ($check < 1) {
            if ($img_height > $height) {
                $image->resize(null, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save();
            }
        }
        if ($check >= 1) {
            if ($img_width > $width) {
                $image->resize($width, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $image->save();
            }
        }
        // Đưa ảnh đã xử lý vào khung
        $img_root->insert($path.$img_name, 'center');
        // if(isset($watermark)) {
        //     $img_root->insert($watermark,'left-top');
        // }
        $img_root->save($path.$img_name);
    }
    public function reOrderImages(Request $request) 
    {
        if ($request->ajax()) {
            $_token = $request->get('_token');
            $ids = $request->get('ids');
            if(isset($ids)) {
                $count = 1;
                foreach ($ids as $id) {
                    DB::table('Product_Images')->where('id', $id)->update(['sort_order' => $count]);
                    $count ++;
                }
            }
        } 
    }

    public function getHotProducts  ()
    {
        $hot_products = Product::where('hot',1)->orderBy('sort_order','asc')->get();

        return view('admin.product.sort_hot_products', compact('hot_products'));
    }
    public function reOrderProducts(Request $request) 
    {
        if ($request->ajax()) {
            $_token = $request->get('_token');
            $ids = $request->get('ids');
            if(isset($ids)) {
                $count = 1;
                foreach ($ids as $id) {
                    DB::table('products')->where('id', $id)->update(['sort_order' => $count]);
                    $count ++;
                }
            }
        } 
    }

    public function removeHot ($id) 
    {
        $product = Product::find($id);
        $product->hot = 0;
        $product->save();
        Session::flash('success','bạn đỡ gỡ bỏ sản phẩm ra khỏi danh sách');
        return redirect('/admin/product/hot-products');
    }


    public function getOfferProducts  ()
    {
        $offer_products = Product::where('offer',1)->orderBy('sort_offer','asc')->get();

        return view('admin.product.sort_offer_products', compact('offer_products'));
    }
    public function reOrderOfferProducts(Request $request) 
    {
        if ($request->ajax()) {
            $_token = $request->get('_token');
            $ids = $request->get('ids');
            if(isset($ids)) {
                $count = 1;
                foreach ($ids as $id) {
                    DB::table('products')->where('id', $id)->update(['sort_offer' => $count]);
                    $count ++;
                }
            }
        } 
    }

    public function removeOfferProduct ($id) 
    {
        $product = Product::find($id);
        $product->hot = 0;
        $product->save();
        Session::flash('success','bạn đỡ gỡ bỏ sản phẩm ra khỏi danh sách');
        return redirect('/admin/product/hot-products');
    }

    public function removeDuplicate ()
    {
        foreach (Product::orderBy('id','asc')->get() as $product) {
            foreach (Product::where('id','>', $product->id)->orderBy('id','asc')->get() as $item) {
                if($product->name == $item->name) {
                    $item->delete();
                }
            }
        }
        return "done";
    }

    public function decodeIntro()
    {
        foreach (Product::all() as $key => $product) {
            $intro = iconv("UTF-8", "ISO-8859-1//TRANSLIT",$product->intro);
            $product->update(['intro' => $intro]);
        }
    }
    public function deleteDropzoneImg (Request $request)
    {
        if ($request->ajax()) {
            $filename = $request->id;
            $uploaded_image = Product_Images::where('original_name', basename($filename))->orderBy('created_at','desc')->first();

            if (empty($uploaded_image)) {
                return Response::json(['message' => 'File không tồn tại'], 400);
            }

            $file_path = 'upload/filemanager/product/gallery/'. $uploaded_image->image;

            if (file_exists($file_path)) {
                File::delete($file_path);
            }

            if (!empty($uploaded_image)) {
                $uploaded_image->delete();
            }

            // return Response::json(['Thông báo' => 'Xóa ảnh thành công'], 200);
        }
    }
    public function dropZoneUploadImg (Request $request, $temp_id)
    {
        if ($request->ajax()) {
            if ($request->hasFile('file')) {
                $imageFiles = $request->file('imgFile');
                // set destination path
                $folderDir = 'upload/filemanager/product/gallery/';
                $destinationPath = public_path() . '/' . $folderDir;
                // this form uploads multiple files
                foreach ($request->file('file') as $fileKey => $fileObject ) {
                    // make sure each file is valid
                    if ($fileObject->isValid()) {
                        // make destination file name
                        $destinationFileName = time() . $fileObject->getClientOriginalName();
                        // move the file from tmp to the destination path
                        $fileObject->move($destinationPath, $destinationFileName);
                        // save the the destination filename
                        $ProductImage = new Product_Images;
                        $ProductImage->image = $destinationFileName;
                        $ProductImage->original_name = basename($fileObject->getClientOriginalName());
                        $ProductImage->product_id = $temp_id;
                        $ProductImage->save();
                        $data[] = $ProductImage->id;
                        // resize 600x600
                        $img_resize = Image::make($destinationPath.$destinationFileName);
                        $img_resize->resize(600,600)->save();
                    }
                }
            }
        }
        return $data;
    }
    public function getData(Request $request) {
        $cat = $request->cate;
        $url = $request->url;
        if(isset($url) && isset($cat)){
            $categories = file_get_html($url);
            foreach(array_reverse($categories->find('.product-page-item .view-content ul li')) as $product) {
                $product_url = $product->find('.image-inner a.image',0)->href;
                $product_url = 'https://cts.com.vn'.$product_url;

                $product_url = $product_url;

                $data['name'] = $product->find('a.title',0)->plaintext;

                $product_detail = file_get_html($product_url);
                $data['cong_dung'] = $product_detail->find('.products-detail .info-product p',0)->innertext;
                $data['cong_dung'] = ltrim($data['cong_dung'],'Công dụng: ');
                $data['cong_dung'] = utf8_encode($data['cong_dung']);


                $data['so_dang_ky'] = $product_detail->find('.products-detail .info-product p',1)->innertext;
                $data['so_dang_ky'] = ltrim($data['so_dang_ky'],'Giấy phép: ');

                $data['quy_cach'] = $product_detail->find('.products-detail .info-product p',2)->innertext;
                $data['quy_cach'] = ltrim($data['quy_cach'],'Quy cách: ');

                $data['sell_price'] = $product_detail->find('div.gia span.text',0)->plaintext;

                if($data['sell_price'] == 'Liên hệ') {
                    $data['sell_price'] = null;
                } else {
                    $data['sell_price'] = preg_replace( '/[^0-9]/', '', $data['sell_price'] );
                    $data['sell_price'] = (int)$data['sell_price'];
                }

                $data['body'] = $product_detail->find('.noi-dung .inner',0)->innertext;
                $data['body'] = $data['body'];

                $image_element = $product_detail->find('.products-detail .image-item .inner img',0);
                if(isset($image_element)) {
                    $data['image'] = $product_detail->find('.products-detail .image-item .inner img',0)->src;
                    $data['image'] = preg_replace('/\?.*/', '', $data['image']);
                    $data['image'] = 'https://songkhoesongvui.vn/'.$data['image'];
                } else {
                    $data['image'] = null;
                }


                $app_test = $this->savePost($cat, $data);
                echo 'Đã đăng sản phẩm '. $data['name'] .'<br />';
            }
        }

    }

    public function savePost ($cate_id, $data)
    {

        $product_add               = new Product;
        $product_add->name         = $data['name'];
        $product_add->catalog_id   = $cate_id;
        $product_add->price        = $data['sell_price'];
        $product_add->intro        = $data['cong_dung'];
        $product_add->quy_cach     = $data['quy_cach'];
        $product_add->so_dang_ky     = $data['so_dang_ky'];
        $product_add->intro     = $data['cong_dung'];
        $product_add->body         = $data['body'];
        $product_add->is_check         = 1;

        // Xử lý ảnh sp
        if($data['image'] != null) {
            $img_name = basename($data['image']);
            while (file_exists('upload/filemanager/product/'.$img_name)) {
                $img_name = str_random(5)."_".$img_name;
            }
            Image::make($data['image'])->save('upload/filemanager/product/' . $img_name);
            $image = Image::make('upload/filemanager/product/' . $img_name);
            $product_add->image         = $img_name;
            // Tạo ảnh Thumbnail
            $image = Image::make('upload/filemanager/product/' . $img_name);
            $image->resize(250,150)->save('upload/filemanager/product/thumbs/'. $img_name);
            // End xử lý ảnh
        } else {
            $product_add->image = null;
        }


        $product_add->save();
    }

    public function getCloneProduct ($id) 
    {
        $product = Product::find($id);
        $catalogs = Catalog::orderBy('sort_order','asc')->get();
        $first_product = Product::orderBy('created_at','desc')->first();
        if($first_product) {
            $first_product_id = $first_product->id + 1000;
        } else {
            $first_product_id = 0;
        }

        return view('admin.product.clone', compact('catalogs','first_product_id','product'));
    }
    public function storeCloneProduct (Request $request) 
    { 
       $this->validate($request, 
        [
            'sltCatalog' => 'required',
            'iptImage'   => 'required|image',
            'iptName'    => 'required',
            'iptPrice'    => 'required',
            'iptCustomSlug' => 'unique:article,slug|unique:cate,slug|unique:catalog,slug|unique:products,slug',
        ],
        [
            'sltCatalog.required' => 'Chưa chọn danh mục',
            'iptName.required'    => 'Chưa nhập tên',
            'iptPrice.required'    => 'Chưa nhập giá bán',
            'iptImage.required'   => 'Bạn chưa nhập ảnh sản phẩm',  
            'iptImage.image'      => 'Định dạng ảnh không hợp lệ', 
            'iptCustomSlug' => 'Đường dẫn đã tồn tại trên hệ thống !',
        ]
    );


       $product_add               = new Product;

       $temp_id = $request->random_temp_id;
       $product_add->name         = $request->iptName;
       $product_add->p_code         = $request->iptCode;
       $product_add->catalog_id   = $request->sltCatalog;
       $product_add->size   = $request->iptSize;

       $product_add->visible      = $request->radioNew;
       $product_add->sale         = $request->radioSale;
       $product_add->sticky       = $request->radioSticky;
       $product_add->price        = $request->iptPrice;
       $product_add->base_price          = $request->iptBasePrice;
       $product_add->intro        = $request->txtCongDung;
       $product_add->body         = $request->txtBody;

       if ($request->hasFile('iptImage')) {
        $file = $request->file('iptImage');
        $file_name = $file->getClientOriginalName();
        $file_name = pathinfo($file_name, PATHINFO_FILENAME); 
        $file_name = str_slug($file_name);
        $file_extension = $file->getClientOriginalExtension();
        $picture = $file_name.'.'.$file_extension;
        $des_path = public_path().'/upload/filemanager/product/';
        while (file_exists('upload/filemanager/product/'.$picture)) {
            $picture = str_random(5)."_".$picture;
        }
        $product_add->image = $picture;
        $file->move($des_path, $picture);
        $image = Image::make('upload/filemanager/product/' . $picture);
        $img_root = Image::make('upload/filemanager/product/root.jpg');
        $this->setimage($image,$picture, $des_path, $img_root, 600, 600);
            // Tạo ảnh Thumbnail
        $image->resize(300,300)->save('upload/filemanager/product/thumbs/'. $picture);
    }
    $product_add->seo_title   = $request->iptSeoTitle;
    $product_add->des        = $request->txtDes;

    $product_add->save();
        // Cập nhật lại Product_ID Anh chi tiet
    $detail_imgs = Product_Images::where('product_id', $temp_id)->get();
    if($detail_imgs->first()) {
        foreach ($detail_imgs as $item) {
            $detail_img = Product_Images::find($item->id);
            $detail_img->product_id = $product_add->id;
            $detail_img->save();
        }
    }
    if (($request->customUrl) == 'on') { 
        $product_add->slug = $request->iptCustomSlug;
        $product_add->custom_url = 1;
    } else {
        $product_add->slug = null;
        $product_add->update(['name' => $request->iptName]);
    }
        // end tags
    $product_add->save();
    Session::flash('success', 'Tạo sản phẩm thành công !');
    return redirect()->route('admin.product.list');       
}

}