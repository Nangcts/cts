@extends('master')

@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thêm mới tài khoản quản trị</strong>
      </header>
      <div class="panel-body">
          <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Tên đăng nhập</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

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
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Mật khẩu</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Nhập lại mật khẩu</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>
            <?php  
            $roles = App\Role::all();
            ?>
            <div class="form-group row">
                <label for="user-role" class="col-md-4 col-form-label text-md-right">Loại tài khoản</label>
                <div class="col-md-6">
                    <select name="sltUserRole" id="user-role" class="form-control" required="required">
                        <option value="">Chọn loại tài khoản</option>
                        @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
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
@endsection
