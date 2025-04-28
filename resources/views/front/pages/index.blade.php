@extends('front.master')

@section('title')

{{ $config->site_title }}

@endsection

@section('des')

{{ $config->site_des }}

@endsection

@section('og')
<meta property="og:url"                content="{{Request::url()}}" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="{{ $config->site_title }}" />
<meta property="og:description"        content="{{ $config->site_des }}" />

<meta property="og:image"              content="{{ asset('upload/filemanager/slider/'.App\Slider::orderBy('sort_order','asc')->first()->slide) }}" />

@endsection
@section('body-class')
home-page
@endsection

@section('slide')
@include('front.blocks.slide')
@endsection

@section('content')
<section class="section-dns-default bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h2 class="section_title">Sản phẩm nổi bật</h2>
            </div>
            <div class="product-list-wrap">
                @foreach (App\Product::where('hot',1)->orderBy('sort_order_1','asc')->take(15)->get() as $item)
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
                                        <span itemprop="price" content="{{ formatPrice($item->sale_price) }}">  {{ formatPrice($item->sale_price) }}đ</span>
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
<?php  
$categories = App\Category::GetRootCategories();
?>
@foreach ($categories as $catalog)
<?php
// Lấy tất cả sản phẩm theo danh mục, sắp xếp sort_order_1 tăng dần
$products = App\Product::whereHas('categories', function($query) use ($catalog) {
    $query->where('categories.id', $catalog->id);
})->orderBy('sort_order_1', 'asc')->take(15)->get();

?>
@if($products->count())
<section class="section-dns-default bg-white">
    <div class="container">
        <div class="row">
            <div class="title-relative">
                <h4 class="title_block left-title">
                    <a href="{{ route('allRoute', $catalog->slug) }}" title="{{ $catalog->name }}">
                        <i class="fa icofont icofont-{{ $catalog->icon }} left"></i> {{ $catalog->name }}
                    </a>
                </h4>
                <div class="right-sub-category hidden-xs">
                    <a href="{{ route('allRoute', $catalog->slug) }}" class="read-all">
                        <i class="fa fa-plus"></i> Xem tất cả
                    </a>
                </div>
            </div>
            <div class="product-list-wrap">
                @foreach ($products as $item)
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
                                <h3 class="h3 product-title" itemprop="name">
                                    <a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a>
                                </h3>
                                <div class="product-price-and-shipping">
                                    <span class="price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                        <span itemprop="priceCurrency" content="VNĐ" @if($item->sale_price) class="old-price" @endif>
                                            @if($item->price == 0) 
                                                Liên hệ 
                                            @else 
                                                {{ formatPrice($item->price) }}đ 
                                            @endif
                                        </span>
                                        @if($item->sale_price)
                                            <span itemprop="price" content="{{ formatPrice($item->sale_price) }}">
                                                {{ formatPrice($item->sale_price) }}đ
                                            </span>
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
@endif
@endforeach

<section class="section-dns-default bg-gray">
    <div class="container">
        <div class="row-news">
            <div class="wrap">
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <h2 class="section_title">Khuyến mãi - Tin tức</h2>
                </div>

                <?php  
                $sale_posts = App\Article::orderBy('created_at','desc')->take(4)->get();
                ?>
                <div class="col-md-6 l-news ft-post">
                    <div class="ft-img-post text-center">
                        <a href="{{ route('allRoute', $sale_posts->first()->slug) }}">
                            <img src="{{ asset('upload/filemanager/article/'. $sale_posts->first()->image) }}" alt="{{ $sale_posts->first()->image }}">
                        </a>
                    </div>
                    <div class="title-post">
                        <h4>
                            <a href="{{ route('allRoute', $sale_posts->first()->slug) }}" title="{{ $sale_posts->first()->title }}">{{ $sale_posts->first()->title }}</a>
                        </h4>
                        <p class="date-time">Đăng vào ngày: <span>{{ \Carbon\Carbon::parse($sale_posts->first()->created_at)->format('d/m/Y') }}</span></p>
                    </div>
                    <div class="excerpt-post nowrap-3">
                        {{ $sale_posts->first()->intro }}
                    </div>
                </div>
                <div class="col-sm-6 r-news right-post">
                    @foreach ($sale_posts as $key => $item)
                    @if($key > 0)
                    <div class="row pb-15">
                        <div class="col-md-6">
                            <div class="ft-img-post text-center">
                                <a href="{{ route('allRoute',$item->slug) }}">
                                    <img src="{{ asset('upload/filemanager/article/'.$item->image) }}" class="attachment-medium size-medium wp-post-image" alt="{{ $item->image }}">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="title-post pt-10 pb-20">
                                <h4 class="nowrap-2">
                                    <a href="{{ route('allRoute',$item->slug) }}" title= "{{ $item->title }}">{{ $item->title }}</a>
                                </h4>
                                <p class="date-time">Ngày đăng: <span>{{ \Carbon\Carbon::parse($sale_posts->first()->created_at)->format('d/m/Y') }}</span></p>
                            </div>
                            <div class="excerpt-post nowrap-3">
                                {{ $item->intro }}
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="dns-section testimonial bg-white">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                <h2 class="section_title" style="color: #000;">CHIA SẺ KHÁCH HÀNG</h2>
            </div>
            <div class="owl-carousel col-lg-12">
                @foreach (App\FeedBack::orderBy('created_at','desc')->get() as $item)
                <div class="testi-item">
                    <div class="testi-mg">
                        <img src="{{ asset('upload/filemanager/feedback/'.$item->image) }}" alt="{{ $item->image }}">
                    </div>
                    <div class="testi-info">
                        <p class="messages">{{ $item->content }}</p>
                        <p class="customer-name text-uppercase">{{ $item->name }}</p>
                        <p class="job">{{ $item->job }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endsection

