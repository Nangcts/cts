@if (isset($brands))
<section class="owl-brands f-all hidden-xs">
    <div class="container">
        <div class="row owl-carousel">
            @foreach ($brands as $item)
            <div class="brand-item">
                <div class="inner">
                    <a href="{{ route('allRoute', $item->slug) }}"><img src="{{ asset('public/upload/brands/' . $item->logo) }}" alt=""></a>
                    <a class="brand-title" href="{{ route('allRoute', $item->slug) }}">{{ $item->name }}</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif