		<table style="background: #f9f9f9; width: 100%">

			<tr>
				<td style="padding: 40px">
					<table style="background: #fff; width: 800px; border: 1px solid #ccc; padding: 30px; margin: 0 auto">
						<tr style="background: #ed1d25; padding: 10px;">
							<td>
								<table>
									<tbody>
										<tr >
											<td style="width: 120px">
												<img style="max-width: 65px; margin: 10px 0;" src="{{ asset('upload/filemanager/logo/' . $config->site_logo) }}">
											</td>
											<td style="color: #fff">
												<h2 style="margin-bottom: 7px">{{ $config->site_title }}</h2><br>
												<div style="margin-bottom: 7px;">
													<strong>
													Số điện thoại liên hệ:   </strong>{{ $config->hotline }} - <strong>Email:   </strong><span style="color: #ccc !important; font-weight: bold;">{{ $config->email }}</span>
												</div>
												<br>
												<address>
													<strong>Địa chỉ:   </strong>Địa chỉ: {{ $config->adress }}
												</address>
												<br>
												<div><strong>Website:   </strong><a href="{{ URL::to('/') }}">{{ URL::to('/') }}</a></div>
											</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr style="padding-top: 20px"><td><div style="margin: 15px 0; font-weight: bold;">Kính chào Quý khách, Cảm ơn Quý khách đã đặt hàng tại {{ $config->site_title }} !</div></td></tr>
						<tr>
							<td>Chi tiết đơn hàng có mã số:<strong>{{ $transaction->id }}</strong> của quý khách vừa đặt như sau:
							</td>
						</tr>
						<tr><td>===============================</td></tr>
						<tr><td><strong style="font-size: 18px; color: #1196cc; margin: 15px 0;">Thông tin hàng đã đặt</strong></td></tr>
						<tr>
							<td>
								<table style="width:100%;border-width: 1px; border-style: dashed;" class="table tbl-cart table-hover table-striped table-responsive">
									<thead style="background: #f5f5f5;">
										<tr>
											<th>(Tên)</th>
											<th>(Size)</th>
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
											<td>
												@if($item->options->size == 0)
												S
												@endif
												@if($item->options->size == 1)
												M
												@endif
												@if($item->options->size == 2)
												L
												@endif
												@if($item->options->size == 3)
												XL
												@endif
											</td>
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
								<table  style="width:100%;border-width: 1px; border-style: dashed;">
									<thead style="background: #f5f5f5;" >
										<tr>
											<th>Họ tên</th>
											<th>Số điện thoại</th>
											<th>Email</th>
											<th>Địa chỉ nhận hàng</th>
											<th>Tin nhắn</th>
										</tr>
									</thead>
									<tbody>
										<tr style="border-bottom: 1px dashed #ccc">
											<td>{{$trans->iptName}}</td>
											<td>{{$trans->iptPhone}}</td>
											<td>{{$trans->iptEmail}}</td>
											<td>{{$trans->iptAdress}}</td>
											<td>{{$trans->txtMessages}}</td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td>Nội thất Khôi Nguyên xin cảm ơn quý khách đã quan tâm và sử dụng dịch vụ của chúng tôi.
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
