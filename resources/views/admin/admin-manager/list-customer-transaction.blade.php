@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        {!! Breadcrumbs::render('admin-customer-transaction', $customer) !!}
        <header class="panel-heading">
          <strong>Đơn đặt hàng của khách hàng: <span>{{ $customer->name }}</span></strong>
        </header>
        <div class="panel-body">
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
              <th>Quản lý đơn</th>
              <th>Thao tác</th>
            </tr>
          </thead>
          <tbody>
            @foreach($transactions as $item)
            <tr class="gradeA" id="tr_{{$item->id}}">
              <td>{!! \Carbon\Carbon::parse($item->created_at)->format('d/m/y') !!}</td>
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
              <td>{{ ($item->customer_id != 0) ? App\Customer::find($item->customer_id)->name : 'Không ĐK' }}</td>
              <td class="center">                              
                <a type="button" class="btn btn-success" href = "{!! route('transaction.viewTransaction',$item->id) !!}"><i class="fa fa-eye"></i> View </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <section class="panel">
        <header class="panel-heading">
          <strong>Thông tin Đơn thuốc đã tải lên</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <table  class="display table table-bordered table-striped table-responsive" id="upload-table">
              <thead>
                <tr>
                  <th>Ngày gửi</th>
                  <th>Họ tên</th>
                  <th>SĐT</th>
                  <th>Địa chỉ</th>
                  <th>File</th>
                </tr>
              </thead>
              <tbody>
                @foreach($uploaded as $item)
                <tr class="gradeA">
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }} </td>
                  <td>{{ $item->customer_name }} </td>
                  <td>{{ $item->customer_phone }} </td>
                  <td>{{ $item->customer_adress }} </td>
                  <td>  <a href="{{ asset('upload/donthuoc/' . $item->file_name) }}">{{ $item->file_name }}</a> </td>
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
    $('#myTable').dataTable({
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

    $('#upload-table').dataTable({
      "pageLength": 10,
      "aaSorting": [[ 0, "desc" ]],
      "iDisplayLength": -1,
      "sPaginationType": "full_numbers",
    });
  });
</script>
@endsection
