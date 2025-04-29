<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;
use File;
use App\Cate;
use App\Article;
use Auth;
use Mail;
use App\Catalog;
use App\Product;
use App\CateGallery;
use App\Gallery;
use App\Slider;
use App\DonThuoc;
use App\Transaction;
use App\Order;
use Illuminate\Support\Facades\Route;
use App\Contact;
use Cart;
use App\Brands;
use Image;
use Session;
use GuzzleHttp\Client;
use App\User;
use App\Notifications\AdminNotification;
use Spatie\Analytics\Period;
use Analytics;

class FrontController extends Controller
{
    public function showAllVideo ()
    {
        return view('front.pages.videos');
    }


    

    public function refreshCaptcha()
    {
        $captcha = captcha_img('flat');
        return captcha_img('flat');
    }
    public function showAllPosts ()
    {
        $posts = Article::orderBy('created_at','desc')->paginate(12);
        return view('front.pages.posts',compact('posts'));
    }

    public function showHotProducts ()
    {
        $hot_products = Product::where('hot',1)->orderBy('sort_order','asc')->paginate(24);
        return view('front.pages.hot_products',compact('hot_products'));
    }

    public function showLastestProducts ()
    {
        $lastest_products = Product::inRandomOrder()->paginate(24);
        return view('front.pages.lastest_products',compact('lastest_products'));
    }

    public function showOfferProducts ()
    {
        $offer_products = Product::where('offer',1)->orderBy('sort_offer','asc')->paginate(24);
        return view('front.pages.offer_products',compact('offer_products'));
    }

    public function getAnalytics ()
    {
        $data['total_views'] = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
        $data['page_views'] = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        $total_views = $data['total_views']->sum('pageViews');
        echo $total_views;
    }
    public function show ($id) 
    {
        $this->authorize('view-post');
        $article = Article::find($id);
        return view('front.test-permission', compact('article'));
    }

    // Gọi trang chủ
    public function getIndex() {
        return view('front.pages.index');
    }
    // Phần dành cho Bài viết
    public function getCatalogArticle ($slug)
    {
        $cate = Cate::whereSlug($slug)->first();

        // Lấy Visa Liên quan
        $term_check = Cate::all();
        $id_arr = get_all_chid($term_check,$cate->id);
        $id_arr =  explode(",", $id_arr);

        $article = DB::table('article')->whereIn('cate_id',$id_arr)->paginate(10);
        $tour = DB::table('tour')->orderBy('created_at','DESC')->take(5)->get();

        return view('front.pages.articleCate',['cate' => $cate, 'article' => $article,'tour' => $tour]);
    }

    public function getDetailArticle ($cate_slug, $slug)
    {
        $article = Article::whereSlug($slug)->first();
        $current_cate = Cate::whereSlug($cate_slug)->first();
        $all_article = Article::where('cate_id',$current_cate->id)->get();


        return view('front.pages.articleDetail',['all_article' => $all_article,'current_cate' => $current_cate, 'article' => $article]);

    }

    public function getAllProductsCategory ($category_id, $pagi = 12)
    {
        $term_check = \App\Category::all();
        $id_arr = get_all_chid($term_check,$category_id);
        $id_arr =  explode(",", $id_arr);
        $all_products = new \Illuminate\Database\Eloquent\Collection;
        foreach ($id_arr as $key => $value) {
            $products = \App\Category::find($value)->products()->orderby('sort_order_1','asc')->get();
            $all_products = $all_products->merge($products);
        }
        $products = $all_products->sortBy('sort_order_1')->paginate($pagi);
        return $products;
    }

    public function getAllLink(Request $r,$slug, $orderby = null)
    {
        $category = \App\Category::whereSlug($slug)->first();
        if($category) {
            $products = $this->getAllProductsCategory($category->id,30);
            return view('front.pages.catalog',['catalog' => $category, 'products' => $products]);
        }


        $catalog = Catalog::whereSlug($slug)->first();

        if (!empty($catalog)) {
            $brand_check = 0;
            $sort = $r->sort;
            $created = $r->created;
            $min_price = $r->min_price;
            $max_price = $r->max_price;
            $brand = $r->brand;
                // lay id con
            $term_check = Catalog::all();
            $id_arr = get_all_chid($term_check,$catalog->id);
            $id_arr =  explode(",", $id_arr);
                // 
            $products = Product::whereIn('catalog_id',$id_arr)->orderBy('created_at', 'DESC')->paginate(24);
                // Neu sap xep theo ngay dang
            if (isset($created)) {
                if ($created == 'asc') {
                    $products = Product::whereIn('catalog_id',$id_arr)->orderBy('created_at', 'asc')->paginate(24);
                } elseif ($created == 'desc') {
                    $products = Product::whereIn('catalog_id',$id_arr)->orderBy('created_at', 'desc')->paginate(24);
                }
            }
                // Neu sap xep theo gia
            if (isset($sort)) {
                if ($sort == 'asc') {
                    $products = Product::whereIn('catalog_id',$id_arr)->orderBy('price', 'asc')->paginate(24);
                } elseif ($sort == 'desc') {
                    $products = Product::whereIn('catalog_id',$id_arr)->orderBy('price', 'desc')->paginate(24);
                }
            } 
                // Neu xem theo Khoang gia
            if (isset($min_price)) {
                $products = Product::whereIn('catalog_id',$id_arr)
                ->where('price','>=',$min_price)
                ->orderBy('price', 'asc')
                ->paginate(24);
                if (isset($max_price)) {
                    $products = Product::whereIn('catalog_id',$id_arr)
                    ->where('price','>=',$min_price)
                    ->where('price','<=',$max_price)
                    ->orderBy('price', 'asc')
                    ->paginate(24);
                }
            }
                // Neu co loc theo thuong hieu
            if (isset($brand)) {
                $products = Product::whereIn('catalog_id',$id_arr)
                ->where('brand_id',$brand)
                ->orderBy('created_at', 'desc')
                ->paginate(24);
            }
            return view('front.pages.catalog',['catalog' => $catalog, 'products' => $products,'brand_check' => $brand_check,'created' => $created, 'sort' => $sort,'brand' => $brand]);
        }

        $catalog = Cate::whereSlug($slug)->first();
        if (!empty($catalog)) { 
            $term_check = Cate::all();
            $id_arr = get_all_chid($term_check,$catalog->id);
            $id_arr =  explode(",", $id_arr);
            $article_cate = Article::whereIn('cate_id',$id_arr)->orderBy('created_at','DESC')->paginate(12);
            if ($article_cate->count() == 1) {
                return redirect()->route('allRoute', $article_cate->first()->slug);
            }
            return view('front.pages.articlecate',['cate' => $catalog,'posts' => $article_cate]);
        }

        $article = Article::whereSlug($slug)->first();

        if (!empty($article)) {
            // dd($article);
            $cate = Cate::where('id',$article->cate_id)->first();
            $tags = $article->tagged;
            $related = Article::where('cate_id',$cate->id)->where('id','<>',$article->id)->orderBy('created_at','DESC')->take(5)->get();
            return view('front.pages.article',['tags' => $tags,'article' => $article, 'catalog' => $cate, 'related' => $related]);
        }
        $product = Product::whereSlug($slug)->first();
        if (!empty($product)) {
            $category = $product->categories->first();
            // dd($category);
            $tags = $product->tagged;
            // get all categories id
            $cate_id = $product->categories->pluck('id');

            $other_products = $category->products->take(12);

            return view('front.pages.product',['product' => $product, 'catalog' => $category,'relate_products' => $other_products, 'tags' => $tags]);
        }
        $tag = DB::table('tagging_tagged')->where('tag_slug', $slug)->first();
        if (!empty($tag)) {
            $article_id = DB::table('tagging_tagged')->where('tag_slug',$slug)->select('taggable_id')->get();
            foreach ($article_id as $item) {
                $article_id_arr[] = $item->taggable_id;
            }
            $posts = DB::table('article')->whereIn('id', $article_id_arr)->paginate(24);
            return view('front.pages.tags',['tag' => $tag, 'posts' => $posts]);
        }

        $video = \App\Video::whereSlug($slug)->first();
        if(!empty($video)) {
            return view('front.pages.video_detail', compact('video'));
        }

    }

    public function postOrder($id, Request $request) {
        if ($request->ajax()) {
            $new_order = (int)$request->get('order');
            $edit_id = (int)$request->get('edit_id');
            $check = $request->get('check');
            if (!empty($new_order)) {
                if ($check == "Catalog") {
                    $item = Catalog::find($edit_id);
                    $item->sort_order = $new_order;
                    $item->save();
                    return $new_order;
                }
                if ($check == "Cate") {
                    $item = Cate::find($edit_id);
                    $item->sort_order = $new_order;
                    $item->save();
                    return $new_order;
                }
                if ($check == "Product") {
                    $item = Product::find($edit_id);
                    $item->sort_order = $new_order;
                    $item->save();
                    return $new_order;
                }
            }
        } else {
            return "fail";
        } 
    }
    public function getBuy(Request $r, $id) {
        $qty = 1;
        if (isset($r->iptQty)) {
            $qty = $r->iptQty;
        }
        $product = Product::find($id);
        $img = '/upload/product/noimage.gif';
        if (!empty($product->image)) {
            $img = $product->image;
        }
        $price = $product->price;
        if($product->sale_price) {
            $price = $product->sale_price;
        }
        Cart::add(['id'=>$id,'name'=>$product->name,'qty'=>$qty,'price'=>$price,'options' => ['img' =>$img,'slug' => $product->slug]]);
        return redirect()->route('cart');
    }

    public function postBuy (Request $request, $id)
    {
        $product = Product::find($id);
        $id_mau = $request->sltMau;
        $mau = \App\Combo::find($id_mau);
        $qty = $request->iptQty;

        $price = $mau->price;
        if($mau->sale_price != 0) {
            $price = $mau->sale_price;
        }

        Cart::add(['id'=>$id,'name'=>$product->name.'-'.$mau->sub_name,'qty'=>$qty,'price'=>$price,'options' => ['img' =>$mau->image,'slug' => $product->slug]]);
        return redirect()->route('cart');

    }

    public function getCart() {
        return view('front.pages.cart');
    }

    public function getDeleteCart() {
        Cart::destroy();
        return back();
    }
    public function back() {
        return back();
    }
    public function updateCart(Request $request) {
        if ($request->ajax()) {
            $qty = $request->get('qty');
            $rowId = $request->get('rowId');
            Cart::update($rowId,$qty);
            // Tạo nội dung giỏ hàng mới
            ?>
            <div class="heading col-lg-12" style="background: #f5f5f5; padding: 7px 10px 7px 15px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px"><span>Đơn hàng của bạn</span></div>
            <table class="table tbl-cart table-hover table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach(Cart::content() as $item) {
                        ?>
                        <tr>
                            <td>
                                <img style="width: 55px" src="<?php echo asset('upload/filemanager/product/thumbs/'.$item->options->img);?>" alt="">
                            </td>
                            <td><a href="<?php echo route('allRoute', $item->options->slug) ?> "><?php echo($item->name) ?></a></td>
                            <td><?php echo number_format($item->price,0,',','.') ?> đ</td>
                            <td>
                                <div class="qty-box">
                                    <span id = "<?php echo($item->rowId) ?>" class = "qty-down">
                                        <i class ="fa fa-minus-square"></i>
                                    </span>
                                    <input id="<?php echo($item->rowId) ?>" type="text" name="qty" min="1" value="<?php echo($item->qty) ?>" style="width:45px; padding: 5px 7px; border: 1px solid #ccc; text-align: center;">
                                    <span id ="<?php echo($item->rowId) ?>" class ="qty-up">
                                        <i class ="fa fa-plus-square"></i>
                                    </span>
                                </div>
                            </td>
                            <td> <?php $sub_total = ($item->price)*($item->qty); echo number_format($sub_total,0,',','.'); ?> đ</td>
                            <td><a href="<?php echo url('/') ?>/remove/<?php echo($item->rowId) ?>" class="btn " style="background: red; display: table; text-align: center; color: #fff; height: 24px; width: 24px; border-radius: 50%;"><i class ="fa fa-remove" ></i></a>
                            </td>
                        </tr>
                        <?php
                        $total = $total + $sub_total;
                    } 
                    ?>
                    <tr><input type="hidden" name="iptTotal" value="<?php echo $total ?>"></tr>
                </tbody>
            </table>
            <table class="table table-striped">
                <tr>
                    <td><label for="">Tổng tiền:</label></td>
                    <td class="total-money" style="color: red; font-weight: bold;font-size: 18px;"><?php echo(number_format($total,0,',','.')); ?> đ</td>
                </tr>
            </table>

        </div>                
        <?php

    }
    else {
        echo "string";
    }
}
public function checkout(Request $request) {
    $this->validate($request, 
        [
            'iptName' => 'required',
            'iptPhone' => 'required',
            'iptAdress' => 'required',
            'captcha' => 'required|captcha',
        ],
        [
            'iptName.required' => 'Bạn chưa nhập tên',
            'iptPhone.required' => 'Bạn chưa nhập số điện thoại',
            'iptEmail.email' => 'Email không đúng',
            'iptAdress.required' => 'Bạn chưa nhập địa chỉ',
            'captcha.required' => 'Chưa nhập mã xác minh',
            'captcha.captcha' => 'Mã xác minh không đúng',
        ]);

    $transaction = new Transaction;

    if (auth::guard('customer')->check()) {
        $transaction->customer_id = auth::guard('customer')->user()->id;
    }
    $transaction->customer_name = $request->iptName;
    $transaction->customer_email = $request->iptEmail;
    $transaction->customer_adress = $request->iptAdress;
    $transaction->customer_phone = $request->iptPhone;
    $transaction->customer_message = $request->txtMessages;
    $transaction->amount = $request->iptTotal;

    $transaction->save();

        // Save to Order Table

    foreach(Cart::content() as $item) {
        $order = new Order;

        $order->product_id = $item->id;
        $order->transaction_id = $transaction->id;
        $order->qty = $item->qty;
        $order->price = $item->price;
        $order->order_amount = ($item->qty)*($item->price);

        $order->save();
    }

    $action_name = __FUNCTION__;
    User::find(1)->notify(new AdminNotification($transaction, $action_name));

    $config = DB::table('config')->first();
    $trans = $request;
    try {
        
    Mail::send('front.email.adminEmail',['trans'=>$trans, 'transaction' => $transaction], function($msg) use ($trans, $transaction, $config) {
        $msg->from('namdangit@gmail.com',$config->site_title);
        $msg->to($config->email,'Đơn đặt hàng mới')->subject('Đơn đặt hàng mới từ website '. $config->site_title .' !');

    });
} catch (\Exception $e) {
    // Nếu có lỗi gửi email thì ghi log hoặc bỏ qua
    \Log::error('Lỗi gửi email: ' . $e->getMessage());

}
        // Gửi email cho khách

    // Mail::send('front.email.customerEmail',['trans'=>$trans, 'transaction' => $transaction], function($msg) use ($trans, $config) {
    //     $msg->from('namdangit@gmail.com',$config->site_title);
    //     $msg->to($trans->iptEmail,'Đơn đặt hàng mới của bạn')->subject('Đơn đặt hàng mới của bạn tại website '. $config->site_title .' !');

    // });
    Cart::destroy();
    Session::flash('success','Đặt hàng thành công! Chúng tôi sẽ liên hệ lại với bạn sớm nhất !');
    return redirect()->route('checkout.success');
}
public function removeCart($rowId) {
    Cart::remove($rowId);
    return redirect()->route('cart');
}
public function checkoutSuccess()
{
    return view('front.pages.checkout_success');
}

public function getContact ()
{
    return view('front.pages.contact');
}


public function search(Request $r)
{

    $this->validate($r, 
        [
            'iptSearch'    => 'required|min:3',
        ],
        [
            'iptSearch.required'    => 'Bạn chưa nhập từ khóa tìm kiếm',
            'iptSearch.min'   => 'Từ khóa phải từ 3 ký tự trở lên',
        ]
    );
    $key = $r->iptSearch;
    $results = DB::table('products')->where('name','like','%'.$key.'%')->paginate(36);
    return view('front.pages.search',['key'=> $key,'results' => $results]);
}
}