@extends('master')
@section('content')
<section class="wrapper">
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
     <header class="panel-heading">
      <strong>Cập nhật trạng thái đơn hàng</strong>
    </header>
  </div>
  <div class="panel-body">
    <h3 class="h3-title">Cập nhật trạng thái</h3>
    <form class="form-horizontal" role="form" action="" method="POST">
      @csrf
      <select class="form-control" name="sltStatus" style="margin: 15px 0; max-width: 250px">
        <option value="0" @if($transaction->status == 0) selected = "selected" @endif>Chờ xác nhận</option>
        <option value="1" @if($transaction->status == 1) selected = "selected" @endif>Đã xác nhận</option>
        <option value="2" @if($transaction->status == 2) selected = "selected" @endif>Đã ship hàng</option>
        <option value="3" @if($transaction->status == 3) selected = "selected" @endif>Hoàn thành</option>
      </select>

      <button type="submit" class="btn btn-success"><i class="fa fa-save"></i>   Lưu</button>
    </form>
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
</section>
@endsection('content')
