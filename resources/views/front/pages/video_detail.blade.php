@extends('front.master')

@section('title')

{{ $video->title }}

@endsection

@section('content')


<section class="dns-section" id="breadcumb-page">
    <div class="container">
        {!! Breadcrumbs::render('home') !!}
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-left sidebar col-sm-3 blog-side">
            <div id="secondary" class="widget_wrapper13" role="complementary">
                <div class="popular-posts">
                    <h2 class="widget-title">Bài viết mới nhất</h2>
                    <div class="widget-content">
                        <ul class="posts-list unstyled clearfix">
                            @foreach(App\Article::orderBy('created_at','desc')->take(5)->get() as $item)
                            <li>
                                <figure class="featured-thumb"> <a href="{{ route('allRoute',$item->slug) }}" title="{{ $item->title }}"> <img src="{{ asset('upload/filemanager/article/'.$item->image) }}" alt="{{ $item->image }}"> </a> </figure>
                                <div class="content-info">
                                    <h4><a href="{{ route('allRoute',$item->slug) }}" title="Lorem ipsum dolor sit amet">{{ $item->title }}</a></h4>
                                    <p class="post-meta">
                                        <time class="entry-date">{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</time> .
                                    </p>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <!--widget-content-->
                </div>
                <!-- Banner Text Block -->
                <div class="text-widget widget widget__sidebar">
                    <h2 class="widget-title">Banner OBH</h2>
                    <div class="widget-content">
                        {!! print_block(5) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-main col-sm-9 main-blog">
            <div id="main" class="video-wrapper">
                <div id="primary" class="site-content">
                    <h1 id="post_title">
                        {{ $video->title }}
                    </h1>
                    <div id="video_detail clearfix">
                        <div class="video-container">
                            {!! convertYoutube($video->link) !!}
                        </div>
                    </div>

                    <div class="more-video row clearfix">
                        @foreach (App\Video::where('id','<>', $video->id)->orderBy('id','desc')->get() as $item)
                        <div class="col-sm-4 col-xs-6 col-video-more">
                            <div class="item-video">

                                <div class="video-image">
                                    <a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->title }}">
                                        <img src="https://img.youtube.com/vi/{{ getYotubeID($item->link) }}/0.jpg" class="">
                                    </a>
                                    <a class="icon various fancybox" href="{{ route('allRoute', $item->slug) }}">
                                        <span class="bg"></span>
                                        <span class="border"></span>
                                    </a>
                                </div>
                                <h3 class="video-item-title"><a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->title }}">{{ $item->title }}</a></h3>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection