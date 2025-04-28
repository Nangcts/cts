<aside>
  <div id="sidebar"  class="nav-collapse ">
    <ul class="sidebar-menu" id="nav-accordion">
      <li>
        <a class="{{ isActiveRoute('dashboard') }}" href="{{ route('dashboard')}}">
          <i class="fa fa-dashboard"></i>
          <span>Trang chính</span>
        </a>
      </li>
      <li class="sub-menu">
        <a href="javascript:;">
          <i class="fa fa-cogs"></i>
          <span>Cấu hình</span>
        </a>
        <ul class="sub">
          <li class="{{ isActiveRoute('getConfig') }}"><a  class="{{ isActiveRoute('getConfig') }}" href="{{ route('getConfig') }}">Cấu hình chung</a></li>
          <li class="{{ isActiveRoute('admin.block.list') }}"><a class="{{ isActiveRoute('admin.block.list') }}" href="{{ route('admin.block.list') }}">Cấu hình khối nội dung</a></li>
        </ul>
      </li>
      
      <li class="sub-menu">
        <a href="javascript:;" class="<?php if(Request::segment(2) == 'product' || Request::segment(2) == 'nested' || Request::segment(2) == 'article') { echo "active"; } ?>">
          <i class="fa fa-pencil"></i>
          <span>Quản trị nội dung</span>
        </a>
        <ul class="sub">
          <li class="{{ isActiveRoute('admin.product.add') }}"><a  href="{!! route('admin.product.add') !!}">Đăng sản phẩm</a></li>
          <li class="{{ isActiveRoute('admin.category.getNested') }}"><a  href="{!! route('admin.category.getNested') !!}">Phân loại sản phẩm</a></li>
          <li class="{{ isActiveRoute('searchProduct') }}"><a  href="{!! route('searchProduct') !!}">Trang sản phẩm</a></li>
          <li class="{{ isActiveRoute('sortHotProducts') }}"><a  href="{!! route('sortHotProducts') !!}">Sản phẩm nổi bật</a></li>
          <li class="{{ isActiveRoute('getOfferProducts') }}"><a  href="{!! route('getOfferProducts') !!}">Sắp xếp sản phẩm</a></li>
          <li class="{{ isActiveRoute('admin.article.add') }}"><a  href="{!! route('admin.article.add') !!}">Đăng bài viết</a></li>
          <li class="{{ isActiveRoute('admin.cate.getNested') }}"><a  href="{!! route('admin.cate.getNested') !!}">Danh mục bài viết</a></li>
          <li class="{{ isActiveRoute('admin.article.list') }}"><a  href="{!! route('admin.article.list') !!}">Bài viết</a></li>
          <!--<li class="{{ isActiveRoute('listVideo') }}"><a  href="{!! route('listVideo') !!}">Quản lý Video</a></li>-->
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" >
          <i class=" fa fa-picture-o"></i>
          <span>Quản lý Slider ảnh</span>
        </a>
        <ul class="sub">

          <li class="{{ isActiveRoute('admin.slider.list') }}"><a  href="{!! route('admin.slider.list') !!}">Slider</a></li>
          <li class="{{ isActiveRoute('admin.slider.add') }}"><a  href="{!! route('admin.slider.add') !!}">Thêm mới slide</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" >
          <i class=" fa fa-comments-o "></i>
          <span>Chia sẻ của khách hàng</span>
        </a>
        <ul class="sub">
          <li class="{{ isActiveRoute('admin.feedback.list') }}"><a  href="{!! route('admin.feedback.list') !!}">Testimonial</a></li>
          <li class="{{ isActiveRoute('admin.feedback.add') }}"><a  href="{!! route('admin.feedback.add') !!}">Thêm mới</a></li>
        </ul>
      </li>


      <li class="sub-menu">
        <a href="javascript:;" >
          <i class="fa fa-shopping-cart"></i>
          <span>Quản lý đơn đặt hàng</span>
        </a>
        <ul class="sub">
          <li class="{{ isActiveRoute('transaction.getAllTransaction') }}"><a  href="{{ route('transaction.getAllTransaction') }}">Quản lý đơn mới</a></li>
        </ul>
      </li>

      <li class="sub-menu">
        <a href="javascript:;" >
          <i class="fa fa-shield"></i>
          <span>Quản trị hệ thống</span>
        </a>
        <ul class="sub">
          <!--<li class="{{ isActiveRoute('admin-manager.getAddUser') }}"><a  href="{{ route('admin-manager.getAddUser') }}">Thêm mới quản trị</a></li>-->
          <li class="{{ isActiveRoute('admin.adminEdit') }}"><a  href="{{ route('admin.adminEdit') }}">Sửa Admin</a></li>
          <!--<li class="{{ isActiveRoute('admin-manager.getListUser') }}"><a  href="{{ route('admin-manager.getListUser') }}">Danh sách quản trị viên</a></li>-->
          <!--<li class="{{ isActiveRoute('admin-manager.listRoles') }}"><a  href="{{ route('admin-manager.listRoles') }}">Quản lý vai trò người dùng</a></li>-->
          <!--<li class="{{ isActiveRoute('admin-manager.getListPermissions') }}"><a  href="{{ route('admin-manager.getListPermissions') }}">Quản lý quyền</a></li>-->
        </ul>
      </li>

    </ul>
  </div>
</aside>