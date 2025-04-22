<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <section class="panel">
   <div class="col-lg-12 header-page-admin">
     {!! Breadcrumbs::render('admin-product-list') !!}
    <header class="panel-heading">
      <strong>Trang sản phẩm</strong>
    </header>
  </div>
  <div class="panel-body ">
    <div class="panel-content-admin">
      <div class="adv-table">
        <div class="pull-left">
          <span class="product_count">Số sản phẩm: {{ $data->count() }}</span>
        </div>
        <div class="btn-group pull-right" style="margin-bottom: 15px;">
          <a  href="{!! route('admin.product.add') !!}" id="editable-sample_new" class="btn btn-primary">
            Thêm Mới <i class="fa fa-plus"></i>
          </a>
        </div>
        <table  class="display table table-bordered table-striped table-responsive" id="product-list">
          @include('admin.blocks.flash')
          <thead>
            <tr>
              <th>id</th>
              <th>Ảnh</th>
              <th>Tên</th>
              <th>Đơn giá</th>
              <th>Giá khuyến mãi</th>
              <th>Ngày đăng</th>
              <th>Danh mục</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $item)
            <tr class="" id="tr_{{$item->id}}">
              <td>{!! $item->id !!}</td>
              <td class="center"><img style = "width:45px; height: 45px;" src="{{ asset('upload/filemanager/product/thumbs/' . $item->image) }}" alt=""> </td>
              <td class="td-name"><a href="{{ route('allRoute', $item->slug) }}">{!!  $item->name !!}</a></td>    
              <td>{!! number_format($item->price,0,",",".") !!} đ</td>
              <td>{!! number_format($item->sale_price,0,",",".") !!} đ</td>
              <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
              <td>
                <?php $categories = App\Product::find($item->id)->categories()->get() ?>
                <ul>
                  @foreach ($categories as $category_item)
                  <li><a href="{{ route('allRoute', $category_item->slug) }}"><i class="fa fa-arrow-right" style="margin-right: 7px; font-size: 10px"></i>{{ $category_item->name }}</a></li>
                  @endforeach
                </ul>
              </td>

              <td class="center">                              
                <a title="Sửa sản phẩm" data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.product.getEdit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                <a title="Xóa sản phẩm" class="btn btn-danger btn-xs" href = "{!! route('admin.product.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Sản phẩm này?')"><i class="fa fa-trash "></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </section>
    </div>
  </div>
</div>
<!-- page end-->
</section>

@endsection
@section('js')
<script type="text/javascript">

  $('.input-group.date').datepicker({  
    format: 'dd/mm/yyyy',
    clearBtn: true,
    locale: 'vi'
  });  

</script>
<script type="text/javascript" charset="utf-8">
// $('#iptFromDate').datepicker({ dateFormat: 'dd-mm-yy' }).val();
$(document).ready( function() {
  $('#product-list').dataTable({
    "pageLength": 50,
    "aoColumnDefs": [
    { "bSortable": false, "aTargets": [ 0, 7 ] }
    ],
    "aaSorting": [[ 1, "desc" ]],
    "iDisplayLength": -1,
    "sPaginationType": "full_numbers",

    // initComplete: function () {
    //   this.api().columns([7]).every( function () {
    //     var column = this;
    //     var select = $('<select><option value="">Tất cả danh mục</option></select>')
    //     .appendTo( $(column.header()).empty() )
    //     .on( 'change', function () {
    //       var val = $.fn.dataTable.util.escapeRegex(
    //         $(this).val()
    //         );

    //       column
    //       .search( val ? '^'+val+'$' : '', true, false )
    //       .draw();
    //     } );

    //     column.data().unique().sort().each( function ( d, j ) {
    //       if(column.search() === '^'+d+'$'){
    //         select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
    //       } else {
    //         var val = $('<div/>').html(d).text();
    //         select.append( '<option value="' + val + '">' + val + '</option>' );
    //       }
    //     } );
    //   } );
    // }

  });
});
$(document).ready( function() {

  $("#filter-button").click(function(){
    $(".filter-row").toggle('slow');
  });
});
</script>
@endsection