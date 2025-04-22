@extends('layouts.app')
@section('content')
<div class="content">
    <div class="card">
    <h3 class="form-title font-green">ĐĂNG NHẬP KHÁCH HÀNG</h3>
        <div class="content-wrapper">
            <form method="POST" action="{{ route('customer.login') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>
                    <div class="">
                        <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="">{{ __('Password') }}</label>
                    <div class="">
                        <input id="password" type="password" class="form-control form-control form-control-solid placeholder-no-fix {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-0">
                    <div class="">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-sign-in"></i>   {{ __('Đăng nhập') }}
                        </button>

                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="copyright">
    <p>
        Copyright <?php echo date("Y"); ?> &copy; NamDangIT: <span>0962241836
        </span>
    </p>
    <p>
        <span class="active">
            <a href="#">
                <img src="{{ asset('css/images/us.png') }} " title="English" alt="English"> <span>English</span>
            </a>
        </span>
        <span>
            <a href="#">
                <img src="{{ asset('css/images/vn.png') }}" title="Tiếng Việt" alt="Tiếng Việt"> <span>Tiếng Việt</span>
            </a>
        </span>
    </p>
</div>
@endsection
