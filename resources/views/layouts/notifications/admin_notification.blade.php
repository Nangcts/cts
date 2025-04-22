<?php \Carbon\Carbon::setLocale('vi'); ?>
@if ($notification->data['action_name'] == 'postAddArticle')
<a href="{{route('allRoute',$notification->data['data']['slug'])}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã viết bài: <strong> {{ $notification->data['data']['title'] }}</strong> <br>
    
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

@if ($notification->data['action_name'] == 'getDeleteArticle')
<a href="#">
    <strong>{{$notification->data['user']['name']}}</strong> đã xóa bài viết: <strong> {{ $notification->data['data']['title'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

@if ($notification->data['action_name'] == 'postEditArticle')
<a href="{{route('allRoute',$notification->data['data']['slug'])}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã cập nhật bài viết: <strong> {{ $notification->data['data']['title'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo từ Catalog -->
@if ($notification->data['action_name'] == 'postAddCatalog')
<a href="{{route('admin.getNested')}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã tạo mới danh mục: <strong> {{ $notification->data['data']['name'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

@if ($notification->data['action_name'] == 'postEditCatalog')
<a href="{{route('admin.getNested')}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã cập nhật danh mục: <strong> {{ $notification->data['data']['name'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo từ sản phẩm -->
@if ($notification->data['action_name'] == 'postAddProduct')
<a href="{{route('allRoute', $notification->data['data']['slug'])}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã đăng sản phẩm: <strong> {{ $notification->data['data']['name'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

@if ($notification->data['action_name'] == 'postEditProduct')
<a href="{{route('allRoute', $notification->data['data']['slug'])}}">
    <strong>{{$notification->data['user']['name']}}</strong> đã sửa sản phẩm: <strong> {{ $notification->data['data']['name'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

@if ($notification->data['action_name'] == 'getDeleteProduct')
<a href="#">
    <strong>{{$notification->data['user']['name']}}</strong> đã xóa sản phẩm: <strong> {{ $notification->data['data']['name'] }}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

<!-- Thông báo đặt hàng từ khách -->
@if ($notification->data['action_name'] == 'checkout')
<a href="{{ route('transaction.viewTransaction',$notification->data['data']['id'] ) }}">
    Khách hàng: <strong>{{$notification->data['data']['customer_name']}}</strong> Đã gửi đơn đặt hàng mới từ website <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo khách hàng đăng ký tài khoản -->
@if ($notification->data['action_name'] == 'customer-registered')
<a href="{{ route('admin-manager.listCustomerAccount') }}">
    <strong>{{$notification->data['data']['name']}}</strong> Đã được đăng ký từ website <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif

<!-- Thông báo khi thêm quận huyện -->
@if ($notification->data['action_name'] == 'postAddRegion')
<a href="{{ route('admin.region.edit', $notification->data['data']['id'] ) }}">
    <strong> Admin</strong> vừa thêm mới quận/huyện: <strong>{{$notification->data['data']['name']}}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo khi sửa quận huyện -->
@if ($notification->data['action_name'] == 'postEditRegion')
<a href="{{ route('admin.region.edit', $notification->data['data']['id'] ) }}">
    <strong> Admin</strong> vừa Sửa quận/huyện: <strong>{{$notification->data['data']['name']}}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo khi đăng ký nhà tuyển dụng thành công-->
@if ($notification->data['action_name'] == 'employer-registered')
<a href="#">
    Nhà tuyển dụng: <strong>{{$notification->data['data']['company_name']}}</strong> vừa được tạo thành công <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif
<!-- Thông báo khi Admin Xóa tin tuyển dụng thành công-->
@if ($notification->data['action_name'] == 'getDeleteTuyenDung')
<a href="#">
    <strong> Admin</strong> vừa Xóa thành công tin đăng: <strong>{{$notification->data['data']['title']}}</strong> <br>
    <span class="notify-time">{{ \Carbon\Carbon::parse($notification->data['create_time']['date'])->diffForHumans() }}</span>
</a>
@endif