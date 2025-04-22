<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Đăng Nhập</title>

    <!-- Bootstrap core CSS -->
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!--external css-->
    <link href="{!! URL('assets/font-awesome/css/font-awesome.css') !!}" rel="stylesheet" />

    <link href="{!! URL('assets/advanced-datatable/media/css/demo_page.css') !!}" rel="stylesheet" />
    <link href="{!! URL('assets/advanced-datatable/media/css/demo_table.css') !!}" rel="stylesheet" />
    <link href="{!! URL('assets/dropzone/css/dropzone.css') !!}" rel="stylesheet"/>

    <!-- Custom styles for this template -->
    <link href="{!! URL('css/admin.css') !!}" rel="stylesheet">
    <link href="{!! URL('css/style-responsive.css') !!}" rel="stylesheet" />
</head>

  <body class="login-body">

    <div class="container">

      <form class="form-signin" action="{!! route('login') !!}" method="POST">
        <h2 class="form-signin-heading">ĐĂNG NHẬP QUẢN TRỊ</h2>
        @include('admin.blocks.error')
        @include('admin.blocks.flash')        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
        <div class="login-wrap">
            <input type="text" class="form-control" placeholder="User ID" autofocus name="txtUsername">
            <input type="password" class="form-control" placeholder="Password" name="txtPassword">
            <label class="checkbox">
                <input type="checkbox" value="remember-me"> Nhớ tài khoản
                <span class="pull-right">
                    <a href="admin/password/reset"> Quên mật khẩu?</a>

                </span>
            </label>
            <button class="btn btn-lg btn-login btn-block" type="submit">Đăng nhập</button>
            <p>Đăng nhập bằng tài khoản khác</p>
            <div class="login-social-link">
                <a href="index.html" class="facebook">
                    <i class="icon-facebook"></i>
                    Facebook
                </a>
                <a href="index.html" class="twitter">
                    <i class="icon-twitter"></i>
                    Twitter
                </a>
            </div>
            <div class="registration">
                <a class="" href="member/register">
                    Đăng ký
                </a>
            </div>

        </div>

          <!-- Modal -->
          <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="myModal" class="modal fade">
              <div class="modal-dialog">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title">Khôi phục mật khẩu ?</h4>
                      </div>
                      <div class="modal-body">
                          <p>Nhập email đăng ký của bạn để tạo mật khẩu mới.</p>
                          <input type="text" name="email" placeholder="Email" autocomplete="off" class="form-control placeholder-no-fix">

                      </div>
                      <div class="modal-footer">
                          <button data-dismiss="modal" class="btn btn-default" type="button">Hủy</button>
                          <button class="btn btn-success" type="button">Gửi</button>
                      </div>
                  </div>
              </div>
          </div>
          <!-- modal -->

      </form>

    </div>



    <!-- js placed at the end of the document so the pages load faster -->
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>    
    <!--common script for all pages-->
    <script src="{!! URL('js/common-scripts.js') !!}"></script>
    <script src="{!! URL('js/custom.js') !!}"></script>
    <script src="{!! URL('js/myscripts.js') !!}"></script>

  </body>
</html>
