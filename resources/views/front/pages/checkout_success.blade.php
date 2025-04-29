@extends('front.master')

@section('title')
{{ $config->site_title }} | Đặt hàng thành công
@endsection

@section('content')
<div class="container" style="padding: 50px 0;">
    <div class="alert alert-success text-center">
        <h1>🎉 Cảm ơn bạn đã đặt hàng!</h1>
        <p>Chúng tôi sẽ liên hệ lại với bạn sớm nhất để xác nhận đơn hàng.</p>
        <a href="{{ route('index') }}" class="btn btn-primary" style="margin-top: 20px;">Mua Tiếp</a>
    </div>
</div>
@endsection
