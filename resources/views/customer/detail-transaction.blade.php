@extends('customer.master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Chi tiết đơn đặt thuốc của bạn</strong>
        </header>
        <div class="panel-body">
          <h3 class="h3-title">Thông tin nhận hàng</h3>
          <div class="adv-table">
             <table class="table table-responsive table-bordered table-gui-don" style="margin-top: 15px;">
              <tr>
                <td style="max-width: 55px;">Ngày đặt (ngày/tháng/năm)</td>
                <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d/m/y') }}</td>
              </tr>
              <tr>
                <td>Tên KH</td>
                <td>{{ $transaction->customer_name }}</td>
              </tr>
              <tr>
                <td>SĐT</td>
                <td>{{ $transaction->customer_phone }}</td>
              </tr>
              <tr>
                <td>Địa chỉ</td>
                <td>{{ $transaction->customer_adress }}</td>
              </tr>
              <tr>
                <td>Tin nhắn</td>
                <td>{{ $transaction->customer_message }}</td>
              </tr>
            </table>
        </div>
        <div class="adv-table">
          <h3 class="h3-title">Chi tiết đơn thuốc</h3>

          <table  class="display table table-bordered table-striped table-responsive">
            @include('admin.blocks.flash')
            <thead>
              <tr>
                <th>Tên thuốc</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Đơn vị</th>
                <th>Giá trị</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $item)
              <tr class="gradeA" id="tr_{{$item->id}}">
                <td>{{ App\Order::find($item->id)->product->name }}</td>
                <td class="center">{{ $item->qty }}</td>
                <td>{{ App\Order::find($item->id)->product->price }}</td>  
                <td>{{ App\Order::find($item->id)->product->unit }}</td>
                
                <td>{!! number_format($item->order_amount,0,",",".") !!} đ</td>
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
