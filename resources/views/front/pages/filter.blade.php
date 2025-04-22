<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Lọc sản phẩm</title>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
	<div class="container">
		<div class="row">
			<aside class="col-lg-4 sidebar">
				<div class="input-price">
					<ul>
						<li><a href="{{ Request::fullUrl() }}{{ $url_char }}min_price=1000000&max_price=3000000">Giá từ 1.000.000 - 3.000000</a></li>
						<li><a href="{{ Request::fullUrl() }}{{ $url_char }}min_price=3000000&max_price=10000000">Giá từ 3.000.000 - 10.000.000</a></li>
					</ul>
				</div>
				<div class="checkbox-brand">
					<?php 
					$catalog = App\Catalog::all();
					if (isset($brands)) {
						$brands = $brands;
					} else {
						$brands = [];
					}
					?>
					@foreach ($catalog as $item)
					<label style="float: left; width:100%">
						<a href="{{ Request::fullUrl() }}{{ $url_char }}brand[]={{ $item->id }}">{{ $item->name }}</a>
					</label>
					@endforeach
				</div>
			</aside>
			<section class="col-lg-8 col-result">
				<ul>
					@if (isset($products))
					@foreach ($products as $item)
					<?php
					$catalog = DB::table('catalog')->where('id', $item->catalog_id)->first();
					?>
					<li>{{ $item->name }} -- {{ number_format($item->price, 0 , ',' , '.') }} VND -- Brand ID: {{ $catalog->name }}</li>
					@endforeach
					@endif
				</ul>
			</section>
		</div>
	</div>
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="Hello World"></script>
</body>
</html>