@extends('master')
@section('content')
<section class="wrapper">

  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      {!! Breadcrumbs::render('admin-product-hot') !!}
      <header class="panel-heading">
        <strong>Quản lý sản phẩm nổi bật</strong>
      </header>
    </div>
    <div class="panel-body">
      <div class="adv-table">
        <div class="hot-product-order-manager">
          <div>
            <a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="">Sắp xếp</a>
            @include('errors.flash')
            <div id="reorder-helper" class="light_box" style="display:none;">1. Kéo thả để xếp lại sản phẩm.<br>2. Click 'Lưu sắp xếp'.</div>
            <div class="hot-product-order">
              <ul class="reorder_ul reorder-photos-list">
                @if(!empty($hot_products))
                @foreach($hot_products as $item)
                <li id="{{$item->id}}" class="ui-sortable-handle col-lg-3 col-md-3 col-sm-3 col-xs-4" style="float: left;width: 100%">
                  <div class="move-icon" style="float: left; margin-right: 15px;">
                    <i class="fa fa-arrows" aria-hidden="true"></i>
                  </div>
                  <div class="inner" style="float: left; margin-right: 25px; min-width: 350px">
                    <a href="javascript:void(0);" style="float:none;" class="image_link" >
                      {{ $item->name }}
                    </a> 
                  </div>
                  <div class="more-link">
                    <a style="padding: 5px 12px; border: 1px solid #ccc;" title="Gỡ sản phẩm khỏi danh sách" class="btn btn-xs" href = "{!! route('removeHotProduct', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ loại sản phẩm này ra khỏi danh sách?')"><i class="fa fa-trash" style="color: red;"></i></a>
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
          $(this).html('').prepend('<img style = "width:35px;" src="{{ asset('images/refresh-animated.gif') }}"/>');
          $("ul.reorder-photos-list").sortable('destroy');
          $("#reorder-helper").html( "Đăng xếp lại thứ tự sản phẩm, vui lòng không thao tác gì khác cho đến khi hoàn thành !" ).removeClass('light_box').addClass('notice notice_error');

          var _token = "{{ csrf_token() }}";
          var h = [];
          $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id'));  });                
          $.ajax({
            type: "POST",
            url: "/admin/product/reorder-hot-products",
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