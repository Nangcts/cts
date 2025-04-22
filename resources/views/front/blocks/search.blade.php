
<form class = "searchform" name ="FrmSearch" action="{{ route('postSearch') }}" method="POST" class="form-horizontal" role="form">
	{{ csrf_field() }}
	<div class="search-frame col-md-4">
		<input type="search" placeholder = "nhập từ khóa" name="iptSearch" id="search-box" class="form-control" value="" title="Tìm kiếm">
		<div id="suggesstion-box"></div>
	</div>
</form>