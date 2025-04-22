@extends('layouts.customer-app')
@section('content')
    <div class="row">
        <div class="col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">Sửa thông tin cá nhân</div>
                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="" enctype="multipart/form-data">
                        @csrf
                        @include('admin.blocks.flash')
                         @include('admin.blocks.error')
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Tên</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name',isset($customer) ? $customer->name : null) }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail (Dùng để đăng nhập)</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email',isset($customer) ? $customer->email : null) }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="changePassword" class="col-md-4 control-label">Đổi mật khẩu</label>
                            <div class="col-md-6">
                                <input type="checkbox" id="changePassword" name="changePassword"> 
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} password">
                            <label for="password" class="col-md-4 control-label">Mật khẩu hiện tại</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" placeholder="">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('newpassword') ? ' has-error' : '' }} password">
                            <label for="newpassword" class="col-md-4 control-label">Mật khẩu mới</label>
                            <div class="col-md-6">
                                <input id="newpassword" type="password" class="form-control" name="newPassword">
                                @if ($errors->has('newpassword'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('newpassword') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>                                          
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} password">
                            <label for="password-confirm" class="col-md-4 control-label">Xác nhận mật khẩu</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Số điện thoại</label>
                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone" value="{{ old('phone',isset($customer) ? $customer->phone : null) }}">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('adress') ? ' has-error' : '' }}">
                            <label for="adress" class="col-md-4 control-label">Địa chỉ</label>
                            <div class="col-md-6">
                                <input id="adress" type="text" class="form-control" name="adress" value="{{ old('adress',isset($customer) ? $customer->adress : null) }}">
                                @if ($errors->has('adress'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('adress') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                             
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i> Lưu
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    // Change Password
    <script>
        $(document).ready(function() {
            $(".password").hide();
            $(document).on('change',function() {
                if($("#changePassword").is(':checked'))
                    $(".password").show();  // checked
                else
                    $(".password").hide();  // unchecked
            });
        });
    </script>
@endsection