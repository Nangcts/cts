@extends('front.master')

@section('title')

{{ $config->site_title }} | Giỏ hàng

@endsection

@section('content')

<?php $check = Cart::content(); ?>

@if(!empty($check))


@include('admin.blocks.flash')
<div class="container">
	<form method="POST" action="{{ route('checkout') }}" name="frm_cart" class="form-horizontal col-xs-12" style="background: #fff; margin-top: 15px; padding-top: 15px">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<div class="cart-control">
			<div class="heading col-lg-12" style="background: #f5f5f5; padding: 7px 10px 7px 15px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px"><span>Đơn hàng của bạn</span></div>
			<table class="table tbl-cart table-hover table-striped table-bordered table-responsive">
				<thead>
					<tr>
						<th>Ảnh</th>
						<th>Tên</th>
						<th>Giá</th>
						<th>Số lượng</th>
						<th>Thành tiền</th>
						<th>xóa</th>
					</tr>
				</thead>
				<tbody>
					<?php $total = 0; ?>
					@foreach(Cart::content() as $item)
					<tr>
						<td><img style="width: 55px" src="{{ asset('upload/filemanager/product/thumbs/' . $item->options->img) }}"></td>
						<?php $product = DB::table('products')->where('id', $item->id)->first(); ?>
						<td><a href="{{ route('allRoute', $product->slug) }}">{{ $item->name }}</a></td>
						<td>{{ number_format($item->price,0,',','.') }} đ</td>
						<td>
							<div class="qty-box">
								<span id = "{{ $item->rowId }}" class = "qty-down">
									<i class ="fa fa-minus-square"></i>
								</span>
								<input id="{{ $item->rowId }}" type="text" name="qty" min="1" value="{{ $item->qty }}" style="width:45px; padding: 5px 7px; border: 1px solid #ccc; text-align: center;">
								<span id ="{{ $item->rowId }}" class ="qty-up">
									<i class ="fa fa-plus-square"></i>
								</span>
							</div>
						</td>
						<?php
						$sub_total = ($item->price)*($item->qty)
						?>
						<td>{{ number_format($sub_total,0,',','.')  }} đ</td>
						<td class="remove-cart"><a href="{{ route('removeCart',$item->rowId) }}" class="btn " style="background: red; display: table; text-align: center; color: #fff; height: 24px; width: 24px; border-radius: 50%;"><i class ="fa fa-remove"></i></a></td>
					</tr>
					<?php $total = $total + $sub_total; ?>
					@endforeach
				</tbody>
			</table>
			<table class="table table-striped">
				<tr>
					<td><label for="">Tổng tiền:</label></td>
					<td class="total-money" style="color: red; font-weight: bold;font-size: 18px;">{{ number_format($total,0,',','.') }} đ</td>
					<input type="hidden" name="iptTotal" value="{{ $total }}">
				</tr>
			</table>
		</div>
		<div class="heading col-lg-12" style="background: #f5f5f5; padding: 7px 10px 7px 15px; text-transform: uppercase; font-weight: bold; margin-bottom: 10px"><span>Thông tin nhận hàng</span></div>
		<div class="check-out-info row clearfix">
			<div class="col-xs-12 col-sm-12 col-lg-8">
				<div class="form-group">
					@include('admin.blocks.error')
					<label for="iptName" class="col-lg-3 col-sm-3 control-label">Họ tên <span style="color: red">(*)</span></label>
					<div class="col-lg-9 col-sm-9">
						<input type="text" class="form-control" name="iptName" placeholder="" value="{{ Auth::guard('customer')->check()?Auth::guard('customer')->user()->name : null }}">
					</div>
				</div>
				<div class="form-group">
					<label for="iptPhone" class="col-lg-3 col-sm-3 control-label">Điện thoại <span style="color: red">(*)</span></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="iptPhone" placeholder="" value="{{ Auth::guard('customer')->check()?Auth::guard('customer')->user()->phone : null }}">
					</div>
				</div>
				
				<div class="form-group">
					<label for="iptAdress" class="col-lg-3 col-sm-3 control-label">Địa chỉ <span style="color: red">(*)</span></label>
					<div class="col-lg-9">
						<input type="text" class="form-control" name="iptAdress" placeholder=""  value="{{ Auth::guard('customer')->check()?Auth::guard('customer')->user()->adress : null }}">
					</div>
				</div>                        
			</div>
			<div class="form-group col-xs-12 col-sm-12 col-lg-4">
				<textarea  class="form-control" name="txtMessages" rows="8" value ="" placeholder ="Yêu cầu của bạn" ></textarea>
			</div> 
			<div class="col-lg-12">
				<label for="password" class="col-form-label text-md-right"  style="float: left; margin-right: 10px;">Mã xác minh</label>
				<input style="float: left; max-width: 160px; margin-right: 7px; height: 37px" type="text" id="captcha" class="form-control{{ $errors->has('captcha') ? ' is-invalid' : '' }}" placeholder="Nhập mã trên ảnh" name ="captcha">

				<div class="captcha" style="float: left;">
					<span>{!! captcha_img('flat') !!}</span>
					<button type="button" class="btn btn-success btn-refresh"><i class="fa fa-refresh"></i></button>
				</div>
			</div>
		</div>
		<div class="form-group col-lg-12 clearfix">
			<div class="col-xs-12 col-sm-12 col-lg-12 pull-right">
				<a class="btn btn-danger pull-right" href ="{{ route('deletecart') }}">Xóa giỏ hàng</a>
				<a class="btn btn-info pull-right" href="{{ route('index') }}">Tiếp tục mua hàng</a>
				<button type="sumit" class="btn btn-success pull-right">Đặt Hàng</button>
			</div>
		</div></form>
		<div class="note-text">(Khi quý khách hoàn thiện đặt hàng, chúng tôi sẽ liên hệ và xác nhận lại đơn hàng một lần nữa trước khi giao hàng) </br><strong>Cảm ơn Quý khách!</strong></div>
		@else
		Không có sản phẩm trong giỏ hàng của bạn!
		@endif
	</div>
	@endsection