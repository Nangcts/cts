@extends('master')
@section('content')

<section class="wrapper">

    <div class="row">

        <div class="col-md-12">

            <div class="panel panel-default">
                <div class="col-lg-12 header-page-admin">
                    <header class="panel-heading">
                        <strong><i class="fa fa-user" style="margin-right: 10px"></i>Sửa thông tin Admin</strong>
                    </header>
                </div>
                <div class="panel-body">
                    <?php
                    $admin = DB::table('users')->where('id',1)->first();
                    ?>
                    <div class="adv-table">
                        <form class="form-horizontal" enctype="multipart/form-data" role="form" method="POST" action="{{ route('postEditAdmin') }}" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            @include('admin.blocks.flash')
                            <div class="form-group{{ $errors->has(' username') ? ' has-error' : '' }}">

                                <label for="username" class="col-md-4 control-label">Tên</label>

                                <div class="col-md-6">

                                    <input id="name" type="text" class="form-control" name="username" value="{{ old('username',isset($admin) ? $admin->name : null) }}" disabled>
                                    @if ($errors->has('username'))

                                    <span class="help-block">

                                        <strong>{{ $errors->first('username') }}</strong>

                                    </span>

                                    @endif

                                </div>

                            </div>
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">

                                <label for="email" class="col-md-4 control-label">E-Mail</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email',isset($admin) ? $admin->email : null) }}" >
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

    </div>

</section>

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