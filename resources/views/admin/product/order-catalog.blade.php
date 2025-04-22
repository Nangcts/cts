<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        {!! Breadcrumbs::render('admin-product-list') !!}
        <header class="panel-heading">
          <strong>Sắp xếp thứ tự sản phẩm</strong>
        </header>
        <div class="panel-body">
         <div class="btn-group pull-right" style="margin-bottom: 15px;">
          <a  href="{!! route('admin.product.add') !!}" id="editable-sample_new" class="btn btn-primary">
            Thêm Mới <i class="fa fa-plus"></i>
          </a>
        </div>
        <div class="adv-table">
          <div class="hot-product-order-manager">
            <div>
              <a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="">Sắp xếp</a>
              @include('errors.flash')
              <div id="reorder-helper" class="light_box" style="display:none;">1. Kéo thả để xếp lại sản phẩm.<br>2. Click 'Lưu sắp xếp'.</div>
              <div class="hot-product-order">
                <ul class="reorder_ul reorder-photos-list">
                  @if(!empty($sort_products))
                  @foreach($sort_products as $item)
                  <li id="{{$item->id}}" class="ui-sortable-handle col-lg-3 col-md-3 col-sm-3 col-xs-4" style="float: left;width: 100%">
                    <div class="move-icon" style="float: left; margin-right: 15px;">
                      <i class="fa fa-arrows" aria-hidden="true"></i>
                    </div>
                    <div class="inner" style="float: left; margin-right: 25px; min-width: 350px">
                      <a href="javascript:void(0);" style="float:none;" class="image_link" >
                        {{ $item->name }}
                      </a> 
                    </div>
                    
                  </li>
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
<!-- page end-->
</section>

@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  $(document).ready(function(){
    $('.reorder_link').on('click',function(){
      $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
      $('.reorder_link').html('Lưu sắp xếp');
      $('.reorder_link').attr("id","save_reorder");
      $('#reorder-helper').slideDown('slow');
      $('.image_link').attr("href","javascript:void(0);");
      $('.image_link').css("cursor","move");
      $("#save_reorder").click(function( e ){
        if( !$("#save_reorder i").length ){
          $(this).html('').prepend('<img src="{{ asset('images/refresh-animated.gif') }}"/>');
          $("ul.reorder-photos-list").sortable('destroy');
          $("#reorder-helper").html( "Đăng xếp lại thứ tự sản phẩm, vui lòng không thao tác gì khác cho đến khi hoàn thành !" ).removeClass('light_box').addClass('notice notice_error');

          var _token = "{{ csrf_token() }}";
          var h = [];
          $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id'));  });                
          $.ajax({
            type: "POST",
            url: "/admin/product/reorder-catalog-products",
            data: {ids: h , _token: _token},
            success: function(){
              $("#reorder-helper").html( "Sắp xếp hoàn thành !" ).removeClass('notice_error').addClass('success-reoder bg-success');
              window.location.reload();
            }
          }); 
          return false;
        }   
        e.preventDefault();     
      });
    });
  });
</script>
@endsection
@section('css')
<link href="{{ asset('css/bootstrap-imageupload.css') }}" rel="stylesheet">
<style>
  .btn-file input[type="file"] {
    cursor: inherit;
    height: 100%;
    opacity: 0;
    width: 100%;
  }
  #dvPreview > img {
    border: 1px solid #f5f5f5;
    margin: 0 5px;
  }
  .col-extra-post .form-group, .col-info-post .form-group {
    margin: 0;
  }
  .btn.btn-default.btn-file {
    height: 35px;
    width: 105px;
  }
  .col-info-post {
    border-right: 5px solid #f5f5f5;
  }
  .panel-body {
    padding-top: 0;
  }

  .hot-product-order a.image_link {
    width: 100%;
  }
  .hot-product-order li {
    border: 1px solid #ccc;
    cursor: move;
    margin: 3px;
    padding: 5px;
    position: relative;
  }
  .image_link > img {
  }
  .hot-product-order .delete-img {
    cursor: pointer;
  }
  .hot-product-order .ui-sortable > li {

    background: #f5f6f8 none repeat scroll 0 0;
    border-bottom: medium none !important;
    margin-bottom: 2px;
    padding: 15px 10px 5px !important;
    position: relative;

  }

</style>
@endsection