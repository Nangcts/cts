@extends('master')
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">

        <div class="col-lg-12 header-page-admin">
          <header class="panel-heading">
            <strong>Đổi mật khẩu người dùng</strong>
          </header>
        </div>
        <div class="panel-body">
          <div class="adv-table">
           <form class="" method="POST" action="{{ route('admin-manager.postEditUser', $user->id) }}">
            @include('errors.flash')
            @csrf
            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">Tên đăng nhập</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', isset($user->name) ? $user->name : null) }}" disabled="true">

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
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', isset($user->email) ? $user->email : null) }}" disabled="true">

                @if ($errors->has('email'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('email') }}</strong>
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
            <?php  
            $roles = App\Role::all();
            ?>
            <div class="form-group row">
              <label for="user-role" class="col-md-4 col-form-label text-md-right">Loại tài khoản</label>
              <div class="col-md-6">
                <select name="sltUserRole" id="user-role" class="form-control" required="required" @if (Auth::guard('web')->user()->id !== 1) disabled="true" @endif>
                  <option value="">Chọn loại tài khoản</option>
                  @foreach ($roles as $role)
                  <option value="{{ $role->id }}" @if ($user->role_id == $role->id) selected @endif>{{ $role->title }}</option>
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

      </div>
    </section>
  </div>
</div>
<!-- page end-->
</section>

@endsection('content')
@section('js')
<script>
  $(document).ready(function() {
    if($("#change-pass").is(':checked'))
      $(".password").show();  // checked
    else {
      $(".password").hide();  // unchecked
    }
    $(document).on('change',function() {
      if($("#seoOptimize").is(':checked'))
        $(".password").show();  // checked
      else {
        $(".password").hide();  // unchecked
      }
    });
  });
</script>
@endsection