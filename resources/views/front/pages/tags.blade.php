@extends('front.master')
@section('title')
{{ $tag->tag_name }}
@endsection

@section('keywords')
{{ $config->site_keywords }}
@endsection

@section('des')
{{ $config->site_des }}
@endsection
@section('og')
<meta property="og:url"                content="{{ Request::url() }}" />
<meta property="og:type"               content="website" />
<meta property="og:title"              content="{{ $tag->tag_name }}" />
<meta property="og:description"        content="{!! $config->site_des !!}" />
<meta property="og:image"              content="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" />
@endsection
<!-- Start Content Page -->
@section('content')
<div class="container">
    <div class="row">
        <div class="breadcrumb-region">
    {!! Breadcrumbs::render('tag', $tag) !!}
</div>
<div class="content-pane">
    <h1 id="page-title">
        {{ $tag->tag_name }}
    </h1>
    <div class="content-list">
        @if(!empty($posts))
        @foreach ($posts as $item)
        <div class="post-item">
            <div class="img-post-item">
                <a href="{{ route('allRoute', $item->slug) }}">
                    <img src="{{ asset('upload/filemanager/article/' . $item->image) }}" alt="">
                </a>
            </div>
            <h4 class="title-post">
                <a href="{{ route('allRoute', $item->slug) }}">{{ $item->title }}</a>
            </h4>
            <p class="intro-post">
                {{ $item->intro }}
            </p>
        </div>
        @endforeach
        @else 
        <p>Nội dung đang được cập nhật, vui lòng quay lại sau !</p>
        @endif
        <div class="col-lg-12">
            {!! $posts->links() !!}
        </div>
    </div>
</div>
    </div>
</div>

@endsection