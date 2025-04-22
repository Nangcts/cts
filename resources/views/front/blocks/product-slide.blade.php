<?php
    $hot_product = DB::table('products')->where('status',1)->orderBy('created_at','DESC')->get();
?>
<section class="own-product">
        <div class="container">
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @if (isset($hot_product))
                    @foreach ($hot_product as $item)
                    <div class=" item  hot-news-item">
                        <div class="item-image">
                            <a href="{{ route('allRoute',$item->slug) }}"><img src="{{ asset('public/upload/product/'.$item->image) }}" alt=""></a>
                        </div>
                        <div class="item-info  ">
                            <a href="{{ route('allRoute',$item->slug) }}" class="item-title">
                                <h3>{{ $item->name }}</h3>
                            </a>

                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </section>