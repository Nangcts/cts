@extends('master')
@section('content')
<section class="wrapper">

  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      {!! Breadcrumbs::render('admin-transaction') !!}
      <header class="panel-heading">
        <strong>Quản lý đơn đặt hàng</strong>
      </header>
    </div>
    <div class="panel-body">
      <div class="adv-table">
        <table  class="display table table-bordered table-striped table-responsive" id="myTable">
          @include('admin.blocks.flash')
          <thead>
            <tr>
              <th>Ngày đặt</th>
              <th>Họ tên</th>
              <th>SĐT</th>
              <th>Số lượng</th>
              <th>Giá trị</th>
              <th>Tình trạng</th>
              <th>Tài khoản</th>
              <th>Quản lý đơn</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transaction as $item)
            <tr class="gradeA" id="tr_{{$item->id}}">
              <td>{!! \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') !!}</td>
              <td class="center">{{ $item->customer_name }}</td>
              <td>{{ $item->customer_phone }}</td>
              <td>{{ App\Transaction::find($item->id)->orders()->sum('qty') }}</td>  
              <td>{!! number_format($item->amount,0,",",".") !!} đ</td>
              <td>
                @if($item->status == 0)
                Đang đợi
                @endif
                @if($item->status == 1)
                Đã xác nhận
                @endif
                @if($item->status == 2)
                Đã ship hàng
                @endif
                @if($item->status == 3)
                Hoàn thành
                @endif
                @if($item->status == 4)
                Đã hủy đơn
                @endif
              </td>
              <td>
                @if ($item->customer_id != 0)
                <a href="{{ route('admin-manager.listCustomerTransaction', $item->customer_id) }}">{{ App\Customer::find($item->customer_id)->name }}</a>
                @else 
                -
                @endif
              </td>
              <td>{{ App\User::find($item->user_id)->name }}</td>
              <td class="center">                              
                <a type="button" class="btn btn-success" href = "{!! route('transaction.viewTransaction',$item->id) !!}"><i class="fa fa-eye"></i> View </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </section>
  
</section>
@endsection('content')

@section('js')
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $(document).ready( function() {
      $('#myTable').dataTable({
        "pageLength": 30,
        // "aaSorting": [[ 0, "desc" ]],
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