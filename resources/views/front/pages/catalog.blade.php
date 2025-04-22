@extends('front.master')
@section('title')
{{ $catalog->name }}
@endsection

@section('des')
{{ $catalog->des }}
@endsection
@section('og')
<meta property="og:url" content="{{Request::url()}}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $catalog->name }}" />
<meta property="og:description" content="{!! $catalog->des !!}" />
<meta property="og:image" content="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" />
@endsection

@section('content')
<section class="dns-section" id="breadcumb-page">
    <div class="container">
        @php
        function getBreadcrumbPaths($category, &$paths = []) {
        array_unshift($paths, [
        'name' => $category->name,
        'url' => route('allRoute', $category->slug)
        ]);

        if ($category->parent_id != 0) {
        $parent = App\Category::find($category->parent_id);
        getBreadcrumbPaths($parent, $paths);
        }

        return $paths;
        }

        // Lấy danh sách breadcrumb
        $breadcrumbs = getBreadcrumbPaths($catalog);

        array_unshift($breadcrumbs, [
        'name' => 'Trang chủ',
        'url' => url('/')
        ]);
        @endphp

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @foreach ($breadcrumbs as $item)
                <li class="breadcrumb-item">
                    @if(!$loop->last)
                    <a href="{{ $item['url'] }}">{{ $item['name'] }}</a>
                    @else
                    <span class="active">{{ $item['name'] }}</span>
                    @endif
                </li>
                @endforeach
            </ol>
        </nav>
    </div>
</section>
<div class="container">
    <div class="row">
        <div class="col-md-12 primary_content">
            <h1 class="heading_product clearfix">
                <span>{{ $catalog->name }}</span>
            </h1>
            <div class="col-lg-12">
            </div>
            <div class="product-list-wrap clearfix">
                <div class="product-list-wrap clearfix">
                    @php
                    use Illuminate\Support\Str;

                    $allProducts = App\Product::whereHas('categories', function($query) use ($catalog) {
                    $query->where('categories.id', $catalog->id);
                    })
                    ->orderBy('sort_order_1', 'asc')
                    ->get();


                    $sortedProducts = $allProducts->sortBy(function($product) use ($catalog) {
                    if (strtolower($product->name) === strtolower($catalog->name)) return 0;
                    elseif (Str::contains(strtolower($product->name), strtolower($catalog->name))) return 1;

                    $keywords = explode(' ', $catalog->name);
                    foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 3 && Str::contains(strtolower($product->name), strtolower($keyword))) {
                    return 2;
                    }
                    }
                    return 3;
                    });


                    $page = request()->get('page', 1);
                    $perPage = 30;
                    $currentPageItems = $sortedProducts->slice(($page - 1) * $perPage, $perPage);
                    $products = new \Illuminate\Pagination\LengthAwarePaginator(
                    $currentPageItems,
                    $sortedProducts->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url()]
                    );
                    @endphp

                    @foreach ($products as $item)
                    <div class="item col-sm-3 col-xs-6 product-item">
                        <article class="" itemtype="http://schema.org/Product">
                            <div class="thumbnail-container">
                                <div class="product-image">
                                    <a href="{{ route('allRoute', $item->slug) }}" class="product-thumbnail">
                                        <img class="img-fluid"
                                            src="{{ asset('upload/filemanager/product/'.$item->image) }}"
                                            alt="{{ $item->image }}">
                                    </a>
                                    <div class="quickview hidden-md-down">
                                        <a href="{{ route('allRoute', $item->slug) }}"
                                            class="quick-view btn-product btn" data-link-action="quickview">
                                            <span class="dns-quickview-bt-loading"></span>
                                            <span class="dns-quickview-bt-content">
                                                <i class="fa fa-search-plus"></i> <span class="title-button">Chi
                                                    tiết</span>
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
                                    <h3 class="h3 product-title" itemprop="name"><a
                                            href="{{ route('allRoute', $item->slug) }}"
                                            title="{{ $item->name }}">{{ $item->name }}</a></h3>
                                    <div class="product-price-and-shipping ">
                                        <span class="price" itemprop="offers" itemscope=""
                                            itemtype="http://schema.org/Offer">
                                            <span itemprop="priceCurrency" content="VNĐ" @if($item->sale_price) class
                                                ="old-price" @endif >@if($item->price == 0) Liên hệ @else
                                                {{ formatPrice($item->price) }}đ @endif</span>
                                            @if($item->sale_price)
                                            <span itemprop="price" content="{{ formatPrice($item->sale_price) }}">
                                                {{ formatPrice($item->sale_price) }}đ</span>
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
                <div class="col-lg-12 clearfix text-center">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
    @endsection