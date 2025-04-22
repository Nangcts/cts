@extends('customer.master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thông tin các đơn đặt hàng của bạn</strong>
        </header>
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
                  <th>Thao tác</th>

                </tr>
              </thead>
              <tbody>
                @foreach($all_transaction as $item)
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
                    Đang ship hàng
                    @endif
                    @if($item->status == 2)
                    Đã hoàn thành
                    @endif
                  </td>
                  <td class="center">                              
                    <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('customer.showDetailOrder',$item->id) !!}"><i class="fa fa-eye"></i></a>
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
@endsection('content')

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