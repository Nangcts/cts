		<table border = 1 style="width:100%;border: 1px;" class="table tbl-cart table-hover table-striped table-responsive">
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
	</div>
	<div style="width:100%;float:left;background:#f5f5f5;margin:10px 0;padding:5px 0"><span>Thông tin nhận hàng</span></div>
		<div class="check-out-info row clearfix">
			<div class="col-xs-12 col-sm-12 col-lg-8">
			<table border = 1 style="width:100%;border: 1px;" >
				<thead style="background: #f5f5f5;" >
					<tr>
						<th>Họ tên</th>
						<th>Số điện thoại</th>
						<th>Địa chỉ nhận hàng</th>
						<th>Tin nhắn</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>{{$trans->iptName}}</td>
						<td>{{$trans->iptPhone}}</td>
						<td>{{$trans->iptAdress}}</td>
						<td>{{$trans->txtMessages}}</td>

					</tr>
				</tbody>
	        </table>
	        </div>          
		</div>

