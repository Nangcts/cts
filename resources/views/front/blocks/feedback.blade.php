<?php $feedbacks = App\FeedBack::orderBy('id','desc')->get() ?>
@if($feedbacks->first())
<section class="feedback padding-30">
    <div class="container">
        <div class="owl-carousel">
            @foreach ($feedbacks as $item)
            <div class="feedback-item">
                <div class="customer-img">
                    <img style="width: 150px; height: 150px;"  src="{{ asset('upload/filemanager/feedback/' . $item->image) }}" alt="{{ $item->image }}">
                </div>
                <div class="customer-name"><span>{{ $item->name }}</span></div>
                <div class="star-horizon">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                </div>
                <div class="customer-adress"><span>{{ $item->adress }}</span></div>
                <div class="feedback-content">{{ $item->content }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif