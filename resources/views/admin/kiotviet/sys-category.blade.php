@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Đồng bộ danh mục từ Kiot Việt</strong>
        </header>
        <div class="panel-body">
          <form method="post" class="form-horizontal" role="form" action = "{{ route('postSysCategoriesKiot') }}">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="bg-warning">
              <p>Lưu ý: việc đồng bộ sẽ ghi đè toàn bộ các dữ liệu từ Kiot Việt lên dữ liệu website đối với các danh mục được lấy từ Kiot Việt (các danh mục được tạo trên website sẽ không bị ảnh hưởng)</p>
            </div>
            <div class="form-group">
              <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Từ ngày (Tháng/Ngày/Năm)</strong></label>
              <div class="col-lg-10">
                <input style="max-width: 250px" type="date" class="form-control" name="iptDateModifi" value="{!! old('iptDateModifi') !!}" >
              </div>
            </div>                        
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">
                <button type="submit" class="btn btn-success " ><i class="icon-save"></i>   Đồng bộ</button>
              </div>
            </div>
          </form>
        </div>
      </section>
    </div>
  </div>
  <!-- page end-->
</section>

@endsection('content')                                              