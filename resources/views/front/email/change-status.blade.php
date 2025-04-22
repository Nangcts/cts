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
										<img style="max-width: 65px; margin: 10px 0;" src="{{ asset('upload/filemanager/logo/'.$config->site_logo ) }}">
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
										<div><strong>Website:   </strong><a href="{{ route('index') }}">{{ route('index') }}</a></div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
				<tr style="padding-top: 20px"><td><div style="margin: 15px 0; font-weight: bold;">Kính chào Quý khách !</div></td></tr>
				<tr><td>Chúng tôi trân trọng thông báo, đơn hàng mã số <strong>{{ $transaction->id }}</strong> của quý khách vừa được Admin cập nhật trạng thái 
					<strong>
						@if($transaction->status == 0)
						Chờ xác nhận
						@endif
						@if($transaction->status == 1)
						Đã xác nhận
						@endif
						@if($transaction->status == 2)
						Chuyển Ship hàng
						@endif
						@if($transaction->status == 3)
						Hoàn thành
						@endif
						@if($transaction->status == 4)
						Hủy đơn
						@endif
					</strong>
				</td>
			</tr>
			<tr><td>===============================</td></tr>
			<tr><td><strong style="font-size: 18px; color: #1196cc; margin: 15px 0;">Thông tin mới về quá trình giao hàng sẽ được chúng tôi cập nhật thường xuyên tới quý khách hàng !</strong></td></tr>
			<tr><td><div style="margin: 25px auto;"></div></td></tr>
			<tr><td><strong>{{ URL('/') }}</strong> xin cảm ơn quý khách đã quan tâm và sử dụng dịch vụ của chúng tôi.

			</td></tr>
			<tr style="padding: 25px 0; background: #434a54; color: #fff">
				<td>
					<div style="">
						<ul>
							<li><label for="" style="font-weight: bold;">Địa chỉ:</label><span style="color: #fff"><br>{{ $config->adress }}</span></li>
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


