<section class="partner-section">
    <div class="uk-container uk-container-center">
        <header class="panel-head">
            <h2 class="heading-1" data-aos="fade-up" data-aos-easing="ease-out-back"><span>Dự án tiêu biểu</span></h2>
        </header>
        <section class="panel-body" data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine">
            <div class="uk-slidenav-position slider" data-uk-slider="{autoplay: true, autoplayInterval: 10500}">
                <div class="uk-slider-container">
                    <?php $tieu_bieu = App\Article::orderBy('id','desc')->take(12)->get() ?>
                    <ul class="uk-slider uk-grid uk-grid-small uk-grid-width-1-2 uk-grid-width-small-1-3 uk-grid-width-medium-1-4 uk-grid-width-large-1-5 uk-grid-width-xlarge-1-5" >
                        @foreach ($tieu_bieu as $key => $item)
                        <li data-slider-slide="{{ $key }}"class="">
                            <div class="thumb">
                                <a class="image img-scaledown" href="{{ route('allRoute', $item->slug) }}" title="{{ asset('upload/article/'.$item->image) }}" draggable="false"><img src="{{ asset('upload/article/'.$item->image) }}" alt="" draggable="false"></a>
                            </div>
                            <div class="title-post">
                                <a href="{{ route('allRoute', $item->slug) }}">{{ $item->title }}</a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-previous" data-uk-slider-item="previous" draggable="false"></a>
                    <a href="" class="uk-slidenav uk-slidenav-contrast uk-slidenav-next" data-uk-slider-item="next" draggable="false"></a>
                </div>
            </div>
            <!-- .slider -->
        </section>
    </div>
</section>