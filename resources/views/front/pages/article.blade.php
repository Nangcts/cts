@extends('front.master')

@section('title')

{{ $article->title }}

@endsection

@section('keywords')

{!! $article->keywords !!}

@endsection

@section('des')

{!! $article->des !!}

@endsection

@section('og')

<meta property="og:url"                content="{{Request::url()}}" />

<meta property="og:type"               content="website" />

<meta property="og:title"              content="{{ $article->title }}" />

<meta property="og:description"        content="{!! $article->des !!}" />

<meta property="og:image"              content="{{ asset('upload/filemanager/article/'.$article->image) }}" />

@endsection

@section('body-class')
gray-body
@endsection

@section('content')
<section class="dns-section" id="breadcumb-page">
    <div class="container">
        {!! Breadcrumbs::render('detail', $catalog, $article) !!}
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-main col-sm-9 main-blog">
            <div class="blog-wrapper">
                <div id="primary" class="site-content">
                    <h1 id="post_title">
                        {{ $article->title }}
                    </h1>
                    <div id="post_detail" role="main">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>
        </div>
        @include('front.blocks.sidebar')
    </div>
</div>
@endsection