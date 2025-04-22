@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý phân quyền trên module</strong>
        </header>
        <div class="panel-body">
          <div class="btn-group pull-right">
            <a  href="{!! route('admin-manager.getAddPermission') !!}" id="editable-sample_new" class="btn btn-info" style="margin-bottom: 15px;">
              Thêm Mới <i class="fa fa-plus"></i>
            </a>
          </div>
          <div class="adv-table">
            <table  class="display table table-bordered table-striped table-responsive" id="list-permission">
              @include('admin.blocks.error')
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên quyền</th>
                  <th>Mã quyền</th>
                  <th>Nhóm quyền</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @foreach($permissions as $item)
                <tr class="gradeA" id="tr_{{$item->id}}">
                  <td>{!! $item->id !!}</td>
                  <td>{{ $item->title }}</td>               
                  <td>{!!  $item->name !!}</td>
                  <td>{{ App\PermissionGroup::find($item->group_id)->title }}</td>
                  <td class="center">                              
                    <a class="btn btn-primary btn-xs" href = "{!! route('admin-manager.getEditPermission',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin-manager.deletePermission', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Quyền này?')"><i class="fa fa-trash "></i></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

          </div>
        </div>
      </section>
    </div>
  </div>
  <!-- page end-->
</section>
@endsection

@section('js')
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $(document).ready( function() {
      $('#list-permission').dataTable({
        "pageLength": 10,
        "aaSorting": [[ 3, "desc" ]],
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": 3 }
        ],
        "iDisplayLength": -1,
        "sPaginationType": "full_numbers",

        initComplete: function () {
          this.api().columns([3]).every( function () {
            var column = this;
            var select = $('<select><option value="">Tất cả nhóm quyền</option></select>')
            .appendTo( $(column.header()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
                );

              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            } );

            column.data().unique().sort().each( function ( d, j ) {
              if(column.search() === '^'+d+'$'){
                select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
              } else {
                var val = $('<div/>').html(d).text();
                select.append( '<option value="' + val + '">' + val + '</option>' );
              }
            } );
          } );
        }

      });
    });
  });
</script>
@endsection

