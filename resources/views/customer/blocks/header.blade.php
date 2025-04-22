      <header class="header white-bg">
        <div class="sidebar-toggle-box">
          <div data-original-title="Toggle Navigation" data-placement="right" class="fa fa-reorder tooltips"></div>
        </div>
        <!--logo start-->
        <a href="{{route('index')}}" class="logo" target="_blank">Trang<span>{{ str_replace('http://',' ',URL('/')) }}</span></a>
        <!--logo end-->
        @can('admin-manager')
        <div class="nav notify-row" id="top_menu">
          <!--  notification start -->
          <ul class="nav top-menu">
            <!-- notification dropdown start-->
            <li id="header_notification_bar" class="dropdown" onclick="markNotificationAsRead('{{count(auth()->user()->unreadNotifications)}}')">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <i class="fa fa-bell"></i>
                <span class="badge bg-warning">{{ count(auth()->guard('web')->user()->unreadNotifications) }}</span>
              </a>
              <ul class="dropdown-menu extended notification">
                <div class="notify-arrow notify-arrow-yellow"></div>
                <li>
                  <p class="yellow">Bạn có {{ count(auth()->guard('web')->user()->unreadNotifications) }} thông báo chưa đọc !</p>
                </li>
                @foreach (App\User::find(1)->Notifications->take(10) as $notification)
                <!-- <span>{{snake_case(class_basename($notification->type))}}</span> -->  
                <li class="notification-item @if($notification->read_at == null) bg-success @endif">
                  @include('layouts.notifications.'.snake_case(class_basename($notification->type)))
                </li>
                @endforeach
              </ul>
            </li>
            <!-- notification dropdown end -->
          </ul>
          <!--  notification end -->
        </div>
        @endcan
        <div class="top-nav ">
          <ul class="nav pull-right top-menu">
            <!-- user login dropdown start-->
            <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <?php $config = DB::table('config')->first(); ?>
                <img style="width:35px; border-radius: 50%" alt="" src="{!! asset('public/upload/logo/' . $config->site_logo) !!}">
                <span class="username" style="color: #fff; font-size: 14px; font-weight: bold">{!! Auth::guard('customer')->user()->name !!}</span>
                <i class="fa fa-angle-down" style="color: #fff; font-size: 16px; margin-left: 7px;"></i>
              </a>
              <ul class="dropdown-menu extended logout">
                <div class="log-arrow-up"></div>
                <li><a href="#"><i class=" fa fa-suitcase"></i>Profile</a></li>
                <li><a href="{{ route('customer.showEditProfile') }}"><i class="fa fa-cog"></i> Đổi mật khẩu</a></li>
                <li><a href="/customer/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-key"></i>   Đăng xuất</a></li>
              </ul>
              <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
            </li>
            <!-- user login dropdown end -->
          </ul>
        </div>
      </header>