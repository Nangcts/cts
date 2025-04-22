@extends('customer.master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thông tin cá nhân của bạn</strong>
        </header>
        <div class="panel-body">
          <?php $customer = auth()->guard('customer')->user() ?>
          <form method="POST" action="{{ route('customer.postEditProfile', $customer->id) }}">
            @include('errors.error')
            @csrf

            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">Tên đăng nhập</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($customer->name) ? $customer->name : null) }}" disabled="true">

                @if ($errors->has('name'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-md-4 col-form-label text-md-right">Email đăng nhập</label>
              <div class="col-md-6">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($customer->email) ? $customer->email : null) }}" disabled="true">

                @if ($errors->has('email'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="phone" class="col-md-4 col-form-label text-md-right">Số điện thoại</label>
              <div class="col-md-6">
                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone', isset($customer->phone) ? $customer->phone : null) }}">

                @if ($errors->has('phone'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group row">
              <label for="adress" class="col-md-4 col-form-label text-md-right">Địa chỉ</label>
              <div class="col-md-6">
                <input id="adress" type="text" class="form-control{{ $errors->has('adress') ? ' is-invalid' : '' }}" name="adress" value="{{ old('adress', isset($customer->adress) ? $customer->adress : null) }}">

                @if ($errors->has('adress'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('adress') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row" >
              <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu cũ</label>

              <div class="col-md-6">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" value="">

                @if ($errors->has('password'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="newPassword" class="col-md-4 col-form-label text-md-right">Mật khẩu mới</label>
              <div class="col-md-6">
                <input id="newPassword" type="password" class="form-control{{ $errors->has('newPassword') ? ' is-invalid' : '' }}" name="newPassword" autofocus>

                @if ($errors->has('newPassword'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('newPassword') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Xác nhận mật khẩu mới</label>
              <div class="col-md-6">
                <input id="password-confirm" type="password" class="form-control" name="new_password_confirmation" >

                @if ($errors->has('new_password_confirmation'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('new_password_confirmation') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-info">
                  <i class="fa fa-save"></i>   Lưu
                </button>
              </div>
            </div>
          </form>

        </div>
      </section>
    </div>
  </div>
  <!-- page end-->
</section>
@endsection('content')