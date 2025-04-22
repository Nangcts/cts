<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">
      <li class="sub-menu">
        <a href="{{ route('customer.showEditProfile') }}">
          <i class="fa fa-user"></i>
          <span>Sửa thông tin cá nhân</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;" >
          <i class="fa fa-shopping-cart"></i>
          <span>Đơn đặt thuốc của bạn</span>
        </a>
        <ul class="sub">
          <li class="{{ isActiveRoute('customer.showAllOrder') }}"><a  href="{{ route('customer.showAllOrder') }}">Đơn chờ xử lý</a></li>
          <li class="{{ isActiveRoute('admin.member.list') }}"><a  href="#">Đơn đã hoàn thành</a></li>
          <li class="{{ isActiveRoute('admin-manager.listRoles') }}"><a  href="#">Đơn hủy</a></li>
        </ul>
      </li>
      <li class="sub-menu">
        <a href="{{ route('customer.showUploadedFile') }}">
          <i class="fa fa-upload"></i>
          <span>Đơn thuốc đã tải lên</span>
        </a>
      </li>

    </ul>
  </div>
</aside>