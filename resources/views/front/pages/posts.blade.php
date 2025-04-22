@extends('front.master')

@section('title')

Trang tin | {{ $config->site_title }}

@endsection

@section('des')

Tin tức

@endsection

@section('og')

<meta property="og:description" content="Trang tin tức">

<meta property="og:image" content="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}">

<meta property="og:image:width" content="1419">

<meta property="og:image:height" content="505">

<meta property="og:locale" content="en_US">

<meta property="og:type" content="article">

<meta property="og:url" content="{{ route('showAllPosts') }}">

<meta property="og:site_name" content="{{ $config->site_title }}">

<meta property="og:title" content="{{ $config->site_title }}">
@endsection

@section('content')
<div class="container nopadding-top">
    <div class="row mg_bottom_20 mg_top_20">
        <div class="col-md-12">
            {!! Breadcrumbs::render('allPost') !!}
        </div>
    </div>
    <div class="row">

        <div class="col-md-9 col-xs-12 primary_content col-md-push-3">
            <div class="col-lg-12">
                <h1 class="heading_product">
                    <span>Trang  tin tức</span>
                </h1>
            </div>
            @foreach ($posts as $item)
            <div class="col-xs-12 post_item">
                <a href="{{ route('allRoute',$item->slug) }}">
                    <div class="post">
                        <h3 class="post-title">
                            {{ $item->title }}
                        </h3>
                        <div class="image-post">
                            <div class="img">
                                <img alt="{{ $item->title }}" src="{{ asset('upload/filemanager/article/'.$item->image) }}" >
                            </div>
                        </div>
                        <div class="post-intro">
                            {{ $item->intro }}
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
            <!--  Pagination  -->
            <div class="col-md-12 col-sm-12 col-xs-12">
                {!! $posts->links() !!}
            </div>
        </div> 
        @include('front.blocks.sidebar')

    </div>
</div>
@endsection