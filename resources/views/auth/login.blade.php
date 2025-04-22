@extends('layouts.app')
@section('content')
<div id="particles-js"></div>
<div class="login-container">

    <form method="POST" action="{{ route('login') }}" enctype="multipart/form-data">
        @csrf
        @include('admin.blocks.error')
        <div class="row">
            <div class="container">
                <div class="login-employer-pane" >
                    <div class="card-header"><i class="fa fa-lock"></i> Đăng nhập quản trị</div>
                    <div class="input-group input-group-icon">
                        <input type="text" name="email" placeholder="email đăng nhập" value="{{ old('email') }}" />
                        <div class="input-icon"><i class="fa fa-envelope"></i></div>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback pull-right" style="color: red; font-size: 11px">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group input-group-icon">
                        <input type="password" name="password" placeholder="Mật khẩu"/>
                        <div class="input-icon"><i class="fa fa-key"></i></div>
                        @if ($errors->has('password'))
                        <span class="invalid-feedback pull-right" style="color: red; font-size: 11px">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="input-group text-right">
                        <button type="submit" class="btn btn-info"><i class="fa fa-sign-in"></i> Đăng nhập</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/particles.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
<style type="text/css">
.login-employer-pane {
    background: #ffffff none repeat scroll 0 0;
    border-radius: 5px;
    left: 50%;
    min-width: 550px;
    padding: 15px;
    position: absolute;
    top: 50px;
    transform: translateX(-50%);
}
.input-group.input-group-icon {
    width: 100%;
}
.input-group.text-right {
    text-align: center;
    width: 100%;
}
@media all and (max-width: 480px) {
    .login-employer-pane {
        min-width: 85%;
    }
} 
</style>
@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/particles.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/particles-js.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var h = $(window).height();
        var y = $('.login-container').height();
        $("#page-content").css('min-height',h);
        $("#particles-js").css('min-height',h);
    })
</script>
@endsection
