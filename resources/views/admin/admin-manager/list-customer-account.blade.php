@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý tài khoản khách hàng (customer Account)</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <table  class="display table table-bordered table-striped table-responsive" id="list-customer-transaction">
              @include('admin.blocks.error')
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Họ tên</th>
                  <th>Email</th>
                  <th>Số ĐT</th>
                  <th>Địa chỉ</th>
                  <th>Trạng thái</th>
                  <th>Ngày tạo</th>
                  <th>Số giao dịch</th>
                  <th>Giá trị</th>
                  <th>Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($customer_acc as $item)
                <tr class="gradeA" id="tr_{{$item->id}}">
                  <td>{!! $item->id !!}</td>
                  <td>{{ $item->name }}</td>
                  <td>{!!  $item->email !!}</td>
                  <td>{!!  $item->phone !!}</td>
                  <td>{!!  $item->adress !!}</td>
                  <td>{{ ($item->active == 0) ? 'Khóa' : 'Hoạt động' }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }}</td>
                  <td>{{ App\Customer::find($item->id)->transactions->count() }}</td>
                  <td>{{ number_format(App\Customer::find($item->id)->transactions->sum('amount'), 0,',','.') }} đ</td>
                  <td class="center">   
                    <a class="btn btn-primary btn-xs" href = "{!! route('admin-manager.listCustomerTransaction',$item->id) !!}"><i class="fa fa-eye"></i></a> 
                    @if ($item->active == 0)    
                    <a class="btn btn-warning btn-xs" href = "{!! route('admin-manager.unLockCustomerAccount',$item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ mở tài khoản này?')" title="Mở khóa"><i class="fa fa-unlock"></i></a>
                    @else
                    <a class="btn btn-warning btn-xs" href = "{!! route('admin-manager.lockCustomerAccount',$item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ khóa tài khoản này?')" title="Khóa tài khoản"><i class="fa fa-lock"></i></a>
                    @endif
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin-manager.deleteCustomerAccount', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa tài khoản này?')"><i class="fa fa-trash "></i></a>
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
      $('#list-customer-transaction').dataTable({
        "pageLength": 30,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": 5 }
        ],
        "iDisplayLength": -1,
        "sPaginationType": "full_numbers",

        initComplete: function () {
          this.api().columns([5]).every( function () {
            var column = this;
            var select = $('<select><option value="">Tất cả trạng thái</option></select>')
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
