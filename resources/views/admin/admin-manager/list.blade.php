<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      <header class="panel-heading">
        <strong>Quản lý thành viên quản trị</strong>
      </header>
    </div>
    <div class="panel-body">

      <div class="adv-table">
        <div class="btn-group pull-right" style="margin-bottom: 10px">
          <a  href="/register" id="editable-sample_new" class="btn btn-primary">
            Thêm Mới <i class="fa fa-plus"></i>
          </a>
        </div>
        <table  class="display table table-bordered table-striped table-responsive" id="myTable">
          @include('admin.blocks.error')
          <thead>
            <tr>
              <th>id</th>
              <th>Tên</th>
              <th>Email</th>
              <th>Loại tài khoản</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($admins as $item)
            <tr class="gradeA" id="tr_{{$item->id}}">
              <td>{!! $item->id !!}</td>
              <td>{{ $item->name }}</td>               
              <td>{!!  $item->email !!}</td>
              <td class="center">
                {{ $item->role->title }}
              </td>
              <td class="center">                              
                <a class="btn btn-primary btn-xs" href = "{!! route('admin-manager.getEditUser',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                <a class="btn btn-danger btn-xs" href = "{!! route('admin.product.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Sản phẩm này?')"><i class="fa fa-trash "></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </section>

</section>

@endsection
@section('js')
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $(document).ready( function() {
      $('#myTable').dataTable({
        "pageLength": 30,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": 5 }
        ],

        // initComplete: function () {
        //   this.api().columns([5]).every( function () {
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
  });
</script>
@endsection