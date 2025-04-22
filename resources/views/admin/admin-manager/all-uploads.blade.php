@extends('master')

@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thông tin Đơn thuốc đã tải lên</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <table  class="display table table-bordered table-striped table-responsive" id="myTable">
              <thead>
                <tr>
                  <th>Ngày gửi</th>
                  <th>Họ tên</th>
                  <th>SĐT</th>
                  <th>Địa chỉ</th>
                  <th>File</th>
                  <th>Tài khoản Khách</th>
                  <th>Trạng thái</th>
                </tr>
              </thead>
              <tbody>
                @foreach($uploads as $item)
                <tr class="gradeA">
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }} </td>
                  <td>{{ $item->customer_name }} </td>
                  <td>{{ $item->customer_phone }} </td>
                  <td>{{ $item->customer_adress }} </td>
                  <td>  <a href="{{ asset('upload/donthuoc/' . $item->file_name) }}">{{ $item->file_name }}</a> </td>
                  <td>
                    @if(!empty($item->customer_id))
                    <a href="{{ route('admin-manager.listCustomerTransaction', $item->customer_id) }}">{{ App\Customer::find($item->customer_id)->name }}</a>
                    @else
                    chưa có tk
                    @endif
                  </td>
                  <td>
                    @if($item->status == 0)
                    Chờ xử lý
                    <a class="confirm-donthuoc" style="margin-left: 7px; cursor: pointer;" id="{{$item->id}}" href="#" title="Xác nhận đã xử lý xong đơn thuốc"><i class="fa fa-check-circle" style="color: red"></i></a>
                    @endif
                    @if($item->status == 1)
                    <i class="fa fa-check-circle" style="color: #41cac0"></i>
                    @endif
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
    $('#myTable').dataTable({
      "pageLength": 50,
      "aaSorting": [[ 0, "desc" ]],
      "aoColumnDefs": [
      { "bSortable": false, "aTargets": 5 }
      ],
      "iDisplayLength": -1,
        "sPaginationType": "full_numbers",

      initComplete: function () {
        this.api().columns([5]).every( function () {
          var column = this;
          var select = $('<select><option value="">Tất cả</option></select>')
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

    $('.confirm-donthuoc').on('click', function() {
      var id = $(this).attr('id');
      var _token = $('input[name = "_token"]').val();
      if (confirm('Bạn muốn muốn cập nhật trạng thái đơn thuốc sang đã xử lý?')) {
        $.ajax({
          type: "GET",
          url: "/admin/admin-manager/confirm-don-thuoc",
          data: {
            "_token": _token,
            "id": id,
          },
          success: function (data) {
           if (data['success']) {
            alert(data['success']);
          } else if (data['error']) {
            alert(data['error']);
          } else {
            alert('Whoops Something went wrong!!');
          }
        }
      });
      }
    });


  });
</script>
@endsection