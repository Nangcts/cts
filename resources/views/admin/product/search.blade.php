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
      <div class="filter-row col-xs-12">
        <form style="margin-top: 15px" action="{{ route('searchProduct') }}" method="GET" class="form-inline" role="form">
          @csrf
          <div class="form-group">
            <label for="">Tên sản phẩm</label><br>
            <input type="text" class="form-control" name="iptName" placeholder="Tên sản phẩm" value="{{ isset($request) ? $request->iptName : null }}">
          </div>
          <div class="form-group">
            <label for="">Ngày đăng từ</label><br>
            <div class="input-group date">
              <input type="text" name="iptFromDate"  class="form-control datepicker" placeholder="Từ ngày ..." autocomplete="off" format="dd/mm/yyyy" value="{{ isset($request) ? $request->iptFromDate : null }}">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="">Ngày đăng đến</label><br>
            <div class="input-group date">
              <input type="text" name="iptToDate" class="form-control datepicker" placeholder="Đến ngày ..." autocomplete="off" format="dd/mm/yyyy" value="{{ isset($request) ? $request->iptToDate : null }}">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-th"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="">Danh mục</label><br>
            <select name="sltCategory" class="form-control select-2">
              <option value="">Chọn danh mục</option>
              <?php $categories = App\Category::orderBy('sort_order','asc')->get() ?>
              @if(isset($request) && $request->sltCategory)
              <?php cate_parent($categories,0," |--",$request->sltCategory); ?>
              @else 
              <?php cate_parent($categories,0," |--"); ?>
              @endif
            </select>
          </div>

          <div class="form-group">
            <label  for="">Xắp xếp theo ngày đăng</label><br>
            <select name="sltCreated" class="form-control select-2">
              <option value="DESC" @if(isset($request) && $request->sltCreated == 'DESC') selected @endif>Từ mới tới cũ</option>
              <option value="ASC" @if(isset($request) && $request->sltCreated == 'ASC') selected @endif>Từ cũ tới mới</option>
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary"> <i class="fa fa-search"></i>   Lọc sản phẩm</button>
          <a style="margin-top: 22px;" type="button" class="btn btn-success" href="{{ route('searchProduct') }}"> <i class="fa fa-search"></i>  Xem tất cả</a>
        </form>
      </div>
      

      <div class="adv-table">
        <div class="pull-left">
          <span class="product_count">Số sản phẩm: {{ $data->total() }}</span>
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
<!--                 <a title="Nhân bản sản phẩm" class="btn btn-info btn-xs" href = "{!! route('getCloneProduct', $item->id) !!}"><i class="fa fa-clone "></i></a> -->
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <div class="paginate-admin" style="text-align: right">
          {!! $data->links() !!}
        </div>
      </section>
    </div>
  </div>
</div>
<!-- page end-->
</section>

@endsection
@section('js')
<!-- <script type="text/javascript">
  $(document).ready(function() {
    $('#master').on('click', function(e) {
      if($(this).is(':checked',true))  
      {
        $(".sub_chk").prop('checked', true);  
      } else {  
        $(".sub_chk").prop('checked',false);  
      }  
    });
    $('.delete_all').on('click', function(e) {

      var allVals = [];  
      $(".sub_chk:checked").each(function() {  
        allVals.push($(this).attr('data-id'));
      });  

      if(allVals.length <=0)  
      {  
        alert("Vui lòng chọn sản phẩm cần xóa!.");  
      }  else {  

        var check = confirm("Bạn có chắc sẽ xóa các bài viết đã chọn?");  
        if(check == true){  

          var join_selected_values = allVals.join(","); 

          $.ajax({
            url: $(this).data('url'),
            type: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: 'ids='+join_selected_values,
            success: function (data) {
              if (data['success']) {
                $(".sub_chk:checked").each(function() {  
                  $(this).parents("tr").remove();
                });
                alert(data['success']);
              } else if (data['error']) {
                alert(data['error']);
              } else {
                alert('Whoops Something went wrong!!');
              }
            },
            error: function (data) {
              alert(data.responseText);
            }
          });

          $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
          });
        }  
      }  
    });
  });
</script> -->
<script type="text/javascript">

  $('.input-group.date').datepicker({  
    format: 'dd-mm-yyyy',
    clearBtn: true,
    locale: 'vi'
  });  

</script>
<script type="text/javascript" charset="utf-8">
// $('#iptFromDate').datepicker({ dateFormat: 'dd-mm-yy' }).val();

$(document).ready( function() {

  $("#filter-button").click(function(){
    $(".filter-row").toggle('slow');
  });
});
</script>
@endsection