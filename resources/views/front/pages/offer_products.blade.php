@extends('front.master')
@section('title')
Sản phẩm giới thiệu | {{ $config->site_title }}
@endsection

@section('des')
Trang tổng hợp Sản phẩm được giới thiệu tới quý khách hàng tại: {{ $config->site_title }}
@endsection
@section('og')
<meta property="og:url"                content="{{Request::url()}}" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="Sản phẩm được giới thiệu tới quý khách hàng tại: {{ $config->site_title }}" />
<meta property="og:description"        content="Trang tổng hợp các sản phẩm nổi bật tại shop {{ $config->site_title }}" />
<meta property="og:image"              content="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" />
@endsection
@section('breadcrumbs')
<div class="breadcrumbs-region">
    <div class="container">
        {!! Breadcrumbs::render('offer-product') !!}
    </div>
</div>
@endsection
<!-- Start Content Page -->
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9 primary_content col-md-push-3">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="heading_product">
                        <span>Sản phẩm giới thiệu</span>
                    </h1>
                </div>
                <div class="product_catalogs_list">
                    @foreach ($offer_products as $item)
                    <div class="col-lg-3 col-sm-3 col-xs-6 col_product">
                        <div class="p-item">
                            <div class="p-img">
                                <div class="img_flex">
                                    <a href="{{ route('allRoute',$item->slug) }}">
                                        @if($item->image != null)
                                        <img src="{{ asset('upload/filemanager/product/thumbs/'.$item->image) }}" alt="">
                                        @else 
                                        <img src="{{ asset('images/icon/no-image.jpg') }}" alt="">
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="p-info">
                                <h4 class="p-name">
                                    <a href="{{ route('allRoute',$item->slug) }}">{{ $item->name }}</a>
                                </h4>

                                <div class="p-price">
                                    <span>{{ formatPrice($item->price) }}đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-lg-12 pull-right">
                        {!! $offer_products->links() !!}
                    </div>
                </div>
            </div>
        </div>
        @include('front.blocks.sidebar')
    </div>
</div>
@endsection