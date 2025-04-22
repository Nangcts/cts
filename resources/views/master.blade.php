<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="shortcut icon" href="">

  <title>HỆ THỐNG QUẢN TRỊ NỘI DUNG</title>
  <!-- Bootstrap core CSS -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&amp;subset=vietnamese" rel="stylesheet">

  <link rel="stylesheet" media="screen" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <!--external css-->
  <link href="{!! URL('assets/font-awesome/css/font-awesome.css') !!}" rel="stylesheet" />
  <link href="{!! URL('assets/advanced-datatable/media/css/demo_page.css') !!}" rel="stylesheet" />
  <link href="{!! URL('assets/advanced-datatable/media/css/demo_table.css') !!}" rel="stylesheet" />
  <link href="{!! asset('assets/selectize/dist/css/selectize.bootstrap3.css') !!}" rel="stylesheet" />
  <link href="{!! asset('assets/selectize/dist/css/selectize.default.css') !!}" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />
  <link href="{!! asset('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') !!}" rel="stylesheet" />


  <!-- Custom styles for this template -->
  @yield('css')
  
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/nestable/jquery.nestable.css') }}" />
  <link rel="stylesheet" href="{!! URL('assets/data-tables/DT_bootstrap.css') !!}" />
  <link rel="stylesheet" href="{!! URL('css/bootstrap-reset.css') !!}" />
  <link href="{!! URL('css/admin.css') !!}" rel="stylesheet">
  
  <link href="{!! URL('css/style-responsive.css') !!}" rel="stylesheet" />


</head>
<body>
  <section id="container" class="">
    <!--header start-->
    @include('admin.blocks.header')
    <!--header end-->
    <!--sidebar start-->
    @include('admin.blocks.slidebar')
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
      @yield('content') 
    </section>
    <!--main content end-->
    <!--footer start-->
    @include('admin.blocks.footer')
    <!--footer end-->
  </section>
  <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="{!! URL('js/jquery.dcjqaccordion.2.7.js') !!}"></script>
  <script src="{!! URL('js/jquery.scrollTo.min.js') !!}"></script>
  <script src="{!! URL('js/respond.min.js') !!}" ></script>
  <!--common script for CKeditor-->
  <script type="text/javascript" src="{!! URL('assets/ckeditor/ckeditor.js') !!}"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  
  <!--common script for all pages-->
  <script src="{!! URL('js/common-scripts.js') !!}"></script>
  <script src="{!! URL('js/myscripts.js') !!}"></script>
  <script src="{!! URL('js/editable-table.js') !!}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
  <script type="text/javascript" src="{!! asset('assets/bootstrap-datepicker/js/bootstrap-datepicker.js') !!}"></script>

      <!-- 
        Dynamic Table 
      -->
      <script type="text/javascript" charset="utf-8">
        function confirmdelete (msg) {
          if (window.confirm(msg)) {
            return true;
          }
          return false;
        }
        $(document).ready(function() {
          $('#example').dataTable( {
            "columnDefs": [
            { "orderable": false, "targets": 0 }
            ],
            "aaSorting": [[ 1, "desc" ]],
            "iDisplayLength": -1,
            "sPaginationType": "full_numbers",
          })
        });
      </script>

      @yield('js')


    </body>
    </html>
