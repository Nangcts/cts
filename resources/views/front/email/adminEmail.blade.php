<table style="background: #f9f9f9; width: 100%">
	<tr>
		<td style="padding: 40px">
			<table style="background: #fff; width: 800px; border: 1px solid #ccc; padding: 30px; margin: 0 auto">
				<tr style="background: #434a54; padding: 10px;">
					<td>
						<table>
							<tbody>
								<tr >
									<td style="width: 120px">
										<img style="max-width: 65px; margin: 10px 0;" src="{{ asset('upload/filemanager/logo/' . $config->site_logo) }}">
									</td>
									<td style="color: #fff">
										<h2 style="margin-bottom: 7px">{{ $config->site_title }}</h2><br>
										<div style="margin-bottom: 7px;"><strong>Số điện thoại liên hệ:   </strong>{{ $config->hotline }} - <strong>Email:   </strong><span style="color: #ccc !important; font-weight: bold;">{{ $config->email }}</span></div>
										<address><strong>Địa chỉ:   </strong>Địa chỉ: {{ $config->adress }}</address>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr style="padding-top: 20px"><td><div style="margin: 15px 0; font-weight: bold;">Hi Admin, Bạn có đơn đặt hàng mới từ website: {{ $config->site_title }} !</div></td></tr>
				<tr>
					<td>Chi tiết đơn hàng có mã số:<strong>{{ $transaction->id }}</strong>  như sau:
					</td>
				</tr>
				<tr><td>===============================</td></tr>
				<tr><td><strong style="font-size: 18px; color: #1196cc; margin: 15px 0;">Thông tin hàng đã đặt</strong></td></tr>
				<tr>
					<td>
						<table style="width:100%;border-width: 1px; border-style: dashed;">
							<thead style="background: #f5f5f5;">
								<tr>
									<th>(Tên)</th>
									<th>(Giá)</th>
									<th>(Số lượng)</th>
									<th>(Thành tiền)</th>
								</tr>
							</thead>
							<tbody>
								<?php $sub_price = 0; $total = 0; $total_discount = 0; ?>
								@foreach(Cart::content() as $item)
								<tr>
									<td>{{ $item->name }}</td>
									<td>{{ number_format($item->price,0,',','.') }} đ</td>
									<td>{{$item->qty}}</td>
									<?php $thanhtien = ($item->price)*($item->qty) ?>
									<td>{{number_format($thanhtien,0,',','.')}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</td>
				</tr>
				<tr><td><label style="font-weight: bold;">Tổng giá trị:   </label>   {{ number_format($trans->iptTotal,0,',','.') }}  đ</td></tr>
				<tr><td>===============================</td></tr>
				<tr><td><strong style="font-size: 18px; color: #1196cc; margin: 15px 0;">Thông tin Khách nhận hàng</strong></td></tr>
				<tr>
					<td>
						<table style="width:100%;border-width: 1px; border-style: dashed;" >
							<thead style="background: #f5f5f5;" >
								<tr>
									<th>Họ tên</th>
									<th>Số điện thoại</th>
									<th>Địa chỉ nhận hàng</th>
									<th>Tin nhắn</th>
								</tr>
							</thead>
							<tbody>
								<tr style="border-bottom: 1px dashed #ccc">
									<td>{{$trans->iptName}}</td>
									<td>{{$trans->iptPhone}}</td>
									<td>{{$trans->iptAdress}}</td>
									<td>{{$trans->txtMessages}}</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr><td>================ Quản lý đơn hàng này ===============</td></tr>
				<tr>
					<td>
						<div style="margin: 25px auto;"><a style="margin: 25px auto;width: 125px; border: 1px solid #1196cc; padding: 7px 10px; text-align: center; background: #f1f1f1; color: #000; text-decoration: none;font-weight: bold; border-radius: 5px; " href="{{ route('transaction.viewTransaction', $transaction->id) }}">Quản lý đơn</a></div>
					</td>
				</tr>
				<tr style="padding: 25px 0; background: #434a54; color: #fff">
					<td>
						<div style="">
							<ul>
								<li><label for="" style="font-weight: bold;">Showroom:</label><span style="color: #fff"><br>{{ $config->adress }}</span></li>
								<li>
									<label for="" style="font-weight: bold;">Hotline: </label> {{ $config->hotline }}
								</li>
							</ul>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>