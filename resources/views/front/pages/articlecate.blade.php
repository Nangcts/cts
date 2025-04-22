@extends('front.master')

@section('title')

{{ $cate->name }}

@endsection

@section('keywords')

{{ $cate->keywords }}

@endsection

@section('des')

{{ $cate->des }}

@endsection

@section('og')

<meta property="og:description" content="{{ $cate->keywords }}">

<meta property="og:image" content="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}">

<meta property="og:image:width" content="1419">

<meta property="og:image:height" content="505">

<meta property="og:locale" content="en_US">

<meta property="og:type" content="article">

<meta property="og:url" content="{{ route('allRoute',$cate->slug) }}">

<meta property="og:site_name" content="{{ $cate->name }}">

<meta property="og:title" content="{{ $cate->name }}">
@endsection
@section('body-class')
gray-body
@endsection
@section('content')
<section class="dns-section" id="breadcumb-page">
    <div class="container">
        {!! Breadcrumbs::render('cate', $cate) !!}
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-main col-sm-9 main-blog">
            <div id="main" class="blog-wrapper">
                <div id="primary" class="site-content">
                    <div id="content" role="main">
                        @foreach ($posts as $item)
                        <article class="blog_entry clearfix">
                            <div>
                                <div class="featured-thumb"><a href="{{ route('allRoute',$item->slug) }}"><img src="{{ asset('upload/filemanager/article/'.$item->image) }}" alt="blog-img3"></a></div>
                                <div class="blog_info">
                                    <header class="blog_entry-header clearfix">
                                        <div class="blog_entry-header-inner">
                                            <h2 class="blog_entry-title"> <a href="{{ route('allRoute',$item->slug) }}" rel="bookmark" title="{{ $item->title }}">{{ $item->title }}</a> </h2>
                                        </div>
                                    </header>
                                    <div class="entry-content">
                                        <ul class="post-meta">
                                            <li><i class="fa fa-user"></i>posted by <a href="#">Admin</a> </li>
                                            <li><i class="fa fa-clock-o"></i><span class="day">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</span> </li>
                                        </ul>
                                        <p>{{ $item->intro }}</p>
                                    </div>
                                </div>

                                <p><a href="{{ route('allRoute',$item->slug) }}" class="post-readmore">Xem chi tiết</a></p>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
                <div class="pager">
                    <div class="pages">
                        {!! $posts->links() !!}
                    </div>
                </div>
            </div>
        </div>
        @include('front.blocks.sidebar')
    </div>
</div>
@endsection