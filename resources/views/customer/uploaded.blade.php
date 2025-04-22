@extends('customer.master')
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
@endsection('content')

@section('js')
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $(document).ready( function() {
      $('#myTable').dataTable({
        "pageLength": 30,
        "aaSorting": [[ 0, "desc" ]],
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": 0 }
        ],
      });
    });
  });
</script>
@endsection