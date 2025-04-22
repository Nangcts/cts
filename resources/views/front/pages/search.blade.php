@extends('front.master')
<!-- Start Content Page -->
@section('content')
<section class="dns-section" id="breadcumb-page">
    <div class="container">
        {!! Breadcrumbs::render('search') !!}
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12 primary_content">
            <h1 class="heading_product clearfix">
                <span>Kết quả tìm kiếm: <strong>{{ $key }}</strong></span>
            </h1>
            <div class="product-list-wrap clearfix">
                @foreach ($results as $item)
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
                                        <span itemprop="priceCurrency" content="VNĐ" @if($item->sale_price) class ="old-price" @endif >{{ formatPrice($item->price) }}</span>
                                        @if($item->sale_price)
                                        <span itemprop="price" content="{{ formatPrice($item->sale_price) }}"> -  {{ formatPrice($item->sale_price) }} Đ</span>
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
                <div class="pull-right clearfix">
                    {!! $results->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection