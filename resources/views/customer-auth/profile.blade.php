@extends('front.master_member')
@section('page-class')
  profile
@endsection
@section('member')
        <section class="panel">
            <form>
              <textarea placeholder="Hôm nay bạn cảm thấy thế nào?" rows="2" class="form-control input-lg p-text-area"></textarea>
            </form>
            <footer class="panel-footer">
              <button class="btn btn-danger pull-right">Đăng</button>
              <ul class="nav nav-pills">
              <li>
                  <a href="#"><i class="icon-map-marker"></i></a>
              </li>
              <li>
                  <a href="#"><i class="icon-camera"></i></a>
              </li>
              <li>
                  <a href="#"><i class=" icon-film"></i></a>
              </li>
              <li>
                  <a href="#"><i class="icon-microphone"></i></a>
              </li>
              </ul>
            </footer>
        </section>
        <section class="panel">
            <div class="bio-graph-heading">
                Cảm ơn bạn đã đăng ký thành viên Kagbe, tại đây các bạn có thể chia sẻ các kiến thức nuôi dạy con yêu đồng thời có thể sử dụng tài khoản này để thuê / mua các sản phẩm phục vụ các bé. Kagbe - Ngôi nhà chung của các con và phụ huynh!.
            </div>
            <div class="panel-body bio-graph-info">
                <h1>Thông tin cá nhân</h1>
                <div class="row">
                  <div class="bio-row">
                      <p><span>Mã tài khoản </span>: {{ $member->id }}</p>
                  </div>
                  <div class="bio-row">
                      <p><span>Họ tên </span>: {{ $member->name }}</p>
                  </div>
                  <div class="bio-row">
                      <p><span>Email </span>: {{ $member->email }}</p>
                  </div>
                  <div class="bio-row">
                      <p><span>Số điện thoại</span>: {{ $member->phone }}</p>
                  </div>
                  <div class="bio-row">
                      <p><span>Địa chỉ </span>: {{ $member->adress }}</p>
                  </div>
                  <div class="bio-row">
                      <p><span>Ngày tham gia</span>: {{ $member->created_at }}</p>
                  </div>
                </div>
            </div>
        </section>
@endsection
@section('js')
<script src="{{ URL('public/flat/assets/jquery-knob/js/jquery.knob.js') }}"></script>
  <script>

      //knob
      $(".knob").knob();

  </script>
@endsection('js')