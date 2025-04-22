@extends('front.master')
@section('title')
{!! $product->name !!}
@endsection
@section('keywords')
{!! $product->keywords !!}
@endsection
@section('des')
{!! $product->des !!}
@endsection
@section('og')
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $product->name }}" />
<meta property="og:description" content="{!! $product->des !!}" />
<meta property="og:image" content="{{ asset('upload/filemanager/product/'.$product->image) }}" />
<meta property="og:image:width" content="600">
<meta property="og:image:height" content="600">
@endsection

@section('content')
<section class="dns-section" id="breadcumb-page">
    <div class="container">
        @php
        function getCategoryBreadcrumbs($category, &$breadcrumbs = []) {
        array_unshift($breadcrumbs, [
        'name' => $category->name,
        'url' => route('allRoute', $category->slug)
        ]);

        if ($category->parent_id != 0) {
        $parent = App\Category::find($category->parent_id);
        getCategoryBreadcrumbs($parent, $breadcrumbs);
        }
        return $breadcrumbs;
        }

        $breadcrumbs = [
        [
        'name' => 'Trang chủ',
        'url' => url('/')
        ]
        ];

        if (isset($catalog)) {
        $categoryCrumbs = getCategoryBreadcrumbs($catalog);
        $breadcrumbs = array_merge($breadcrumbs, $categoryCrumbs);
        }

        if (isset($product)) {
        $breadcrumbs[] = [
        'name' => $product->name,
        'url' => null
        ];
        }
        @endphp

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $crumb)
                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                    @if($crumb['url'] && !$loop->last)
                    <a href="{{ $crumb['url'] }}">{{ $crumb['name'] }}</a>
                    @else
                    {{ $crumb['name'] }}
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
    </div>
</section>
<section id="product_detail">
    <div class="container">
        <div class="row">
            <div id="primary-content" class="col-md-12 primary_content">
                <div class="category-row-products">
                    <div class="product-detail row clearfix" itemscope="" itemtype="”http://schema.org/FurnitureStore">
                        <div class="product-detail-img col-sm-6 col-xs-12">
                            <!-- <div class="item">
                                <img src="{{ asset('upload/filemanager/product/'.$product->image) }}" alt="{{ $product->image }}">
                            </div> -->
                            <?php $gallerys = DB::table('product_images')->where('product_id', $product->id)->orderBy('sort_order','asc')->get() ?>
                            <div class="owl-carousel img-detail-p" data-slider-id="1">
                                <div class="item">
                                    <img src="{{ asset('upload/filemanager/product/'.$product->image) }}" alt="">
                                </div>
                                @if (count($gallerys) != 0)
                                @foreach ($gallerys as $item)
                                <div class="item">
                                    <img src="{{ asset('upload/filemanager/product/gallery/'.$item->image) }}" alt="">
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="product-detail-info col-sm-6 col-xs-12">
                            <h1 class="title-1" itemprop="name" itemtype="products">
                                {{ $product->name }}
                            </h1>


                            <div class="detail-field">
                                <span class="p-price @if($product->sale_price) old-price @endif">@if($product->price ==
                                    0) Liên hệ @else {{ formatPrice($product->price) }}đ @endif</span>
                            </div>
                            @if($product->sale_price)
                            <div class="detail-field">
                                <span class="p-price">{{ formatPrice($product->sale_price) }}đ</span>
                            </div>
                            @endif
                            <div class="detail-field field-intro">
                                {!! $product->intro !!}
                            </div>

                            <div class="detail-field promo-wraper">
                                <span><i class="fa fa-gift"></i> Khuyến mãi</span>
                                <div class="promo-content">
                                    <p style="color:red">
                                        @if($product->sale_content) {{ $product->sale_content }} @else Gọi Hotline
                                        {{ $config->hotline }} để nhận nhiều ưu đãi hấp dẫn ! @endif
                                    </p>
                                </div>
                            </div>
                            <div class="detail-field">
                                @if($product->combos->count())
                                <div class="related_post related-post-more">
                                    <ul>
                                        @foreach ($product->combos as $item)
                                        <li><i class="fa fa-angle-right" style="margin-right: 10px"></i>
                                            {{ $item->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                            <div class="detail-field social-field">
                                <div class="detail-field">
                                    <div id="block-reassurance">
                                        <ul>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="{{ asset('images/icon/ic_verified_user_black_36dp_1x.png') }}"
                                                        alt="">
                                                    <a class="h6" href="#">Bảo hành tại chỗ</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="{{ asset('images/icon/ic_local_shipping_black_36dp_1x.png') }}"
                                                        alt="">
                                                    <a class="h6" href="#">Giao hàng nhanh chóng</a>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="block-reassurance-item">
                                                    <img src="{{ asset('images/icon/ic_swap_horiz_black_36dp_1x.png') }}"
                                                        alt="">
                                                    <a class="h6" href="#">Đổi trả khi có lỗi</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="fb-share-button" data-href="{{ Request::URL() }}" data-layout="button_count"
                                    data-size="small"><a target="_blank"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ Request::URL() }}"
                                        class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                                <div class="zalo_chat"><a href="http://zalo.me/{{ $config->hotline }}"><img
                                            src="{{ asset('images/icon/zalo_small.png') }}">Inbox Zalo</a></div>
                            </div>
                            <div class="detail-field margin-15">
                                <div class="button-buy clearfix">
                                    <a href="{{ route('buy',$product->id) }}" class="btn-buy-now btn">
                                        <span><i class="icofont-shopping-cart"></i> Mua Ngay</span><br>
                                        <span class="note-buy">Đặt và nhận hàng qua hình thức ship COD</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="product-more col-lg-12">

                            @if($product->articles->count())
                            <div class="related_post related-post-more">
                                <ul>
                                    @foreach ($product->articles as $item)
                                    <li><a href="{{ route('allRoute',$item->slug) }}"><i class="fa fa-angle-right"
                                                style="margin-right: 10px"></i> {{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif



                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="product-more col-lg-12">

                        @if($product->articles->count())
                        <div class="related_post related-post-more">
                            <ul>
                                @foreach ($product->articles as $item)
                                <li><a href="{{ route('allRoute',$item->slug) }}"><i class="fa fa-angle-right"
                                            style="margin-right: 10px"></i>
                                        {{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</section>

<section class="section-dns-margin section-p-body bg-white margin-25 clearfix">
    <div class="container">
        <div class="tabs tabs-info clearfix">
            <ul class="nav nav-tabs">
                <li class="nav-item active">
                    <a class="nav-link" data-toggle="tab" href="#description" aria-expanded="true">Chi tiết sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#product-comments">Bình luận</a>
                </li>
            </ul>
            <div class="tab-content" id="tab-content">
                <div class="tab-pane fade active in" id="description" aria-expanded="true">
                    <div class="product-description">
                        {!! $product->body !!}
                    </div>
                </div>
                <div class="tab-pane fade" id="product-comments">

                    <div class="face-comment">
                        <div class="fb-comments" data-href="{{ Request::URL() }}" data-numposts="5" data-width="100%">
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
<section class="section-dns-default bg-white">
    <div class="container">
        <div class="row">
            <h4 class="title_block clearfix">
                Sản phẩm tương tự
            </h4>
            <div class="product-list-wrap related-products clearfix">
                @php
                use Illuminate\Support\Str;
                $relatedProducts = App\Product::whereHas('categories', function($query) use ($catalog) {
                        $query->where('categories.id', $catalog->id);
                    })
                    ->where('id', '!=', $product->id) 
                    ->orderBy('sort_order_1', 'asc')
                    ->take(20) // Lấy nhiều hơn để có thể lọc
                    ->get();

                $sortedProducts = $relatedProducts->sortBy(function($item) use ($product) {

                    if (strtolower($item->name) === strtolower($product->name)) {
                        return 0;
                    }

                    if (Str::contains(strtolower($item->name), strtolower($product->name))) {
                        return 1;
                    }

                
                    $keywords = explode(' ', $product->name);
                    foreach ($keywords as $keyword) {
                        if (strlen($keyword) > 3 && Str::contains(strtolower($item->name), strtolower($keyword))) {
                            return 3;
                        }
                    }
                    
                    // Ưu tiên 5: Các sản phẩm khác cùng danh mục
                    return 4;
                })->take(10); 
                @endphp

                @foreach ($sortedProducts as $item)
                <div class="item col-sm-3 col-xs-6 product-item">
                    <article class="" itemtype="http://schema.org/Product">
                        <div class="thumbnail-container">
                            <div class="product-image">
                                <a href="{{ route('allRoute', $item->slug) }}" class="product-thumbnail">
                                    <img class="img-fluid" src="{{ asset('upload/filemanager/product/'.$item->image) }}" alt="{{ $item->image }}">
                                </a>
                                <div class="quickview hidden-md-down">
                                    <a href="{{ route('allRoute', $item->slug) }}" class="quick-view btn-product btn" data-link-action="quickview">
                                        <span class="dns-quickview-bt-loading"></span>
                                        <span class="dns-quickview-bt-content">
                                            <i class="fa fa-search-plus"></i> <span class="title-button">Chi tiết</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                            <div class="product-meta">
                                <div class="leo-list-product-reviews">
                                    <div class="leo-list-product-reviews-wraper">
                                        <div class="star_content clearfix">
                                            <div class="star"></div>
                                            <div class="star"></div>
                                            <div class="star"></div>
                                            <div class="star"></div>
                                            <div class="star"></div>
                                        </div>
                                    </div>
                                </div>
                                <h3 class="h3 product-title" itemprop="name"><a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a></h3>
                                <div class="product-price-and-shipping ">
                                    <span class="price" itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                                        <span itemprop="priceCurrency" content="VNĐ" @if($item->sale_price) class ="old-price" @endif >@if($item->price == 0) Liên hệ @else {{ formatPrice($item->price) }}đ @endif</span>
                                        @if($item->sale_price)
                                        <span itemprop="price" content="{{ formatPrice($item->sale_price) }}"> - {{ formatPrice($item->sale_price) }}đ</span>
                                        @endif
                                    </span>
                                </div>

                                <ul class="product-flags">
                                    @if($item->sale_price)
                                    <li class="product-flag new">Sale</li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="{{ asset('assets/owl-thumbs/dist/owl.carousel2.thumbs.js') }}"></script>
<script src="{{ asset('assets/owl-thumbs/dist/owl.carousel2.thumbs.min.js') }}"></script>
<script type="text/javascript">
$('.owl-carousel.img-detail-p').owlCarousel({
    items: 1,
    thumbs: true,
    thumbImage: true,
    thumbContainerClass: 'owl-thumbs',
    thumbItemClass: 'owl-thumb-item'
});
</script>
@endsection