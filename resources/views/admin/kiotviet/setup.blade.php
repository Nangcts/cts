@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Kết nối Kiốt Việt</strong>
                </header>
                <div class="panel-body">
                  <form method="post" class="form-horizontal" role="form" action = "{{ route('postSetupKiot', $kiot->id) }}">
                      @include('admin.blocks.flash')
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên shop</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptName" value="{!! old('iptName', isset($kiot) ? $kiot->name : null) !!}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptRetailer" class="col-lg-2 col-sm-2 control-label"><strong>Retailer (tiền tố trên  URL của shop)</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptRetailer" value="{!! old('iptRetailer', isset($kiot) ? $kiot->retailer : null) !!}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptClientID" class="col-lg-2 col-sm-2 control-label"><strong>Client ID</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptClientID" value="{!! old('iptClientID', isset($kiot) ? $kiot->client_id : null) !!}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptCode" class="col-lg-2 col-sm-2 control-label"><strong>Mã bảo mật</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" type="text" name="iptCode" value="{!! old('iptCode', isset($kiot) ? $kiot->client_code : null) !!}" >
                          </div>
                      </div>                                                 
                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-success " ><i class="icon-save"></i>   Lưu</button>
                              <a type="button" class="btn btn-default" href="{{ route('testConnectKiot') }}">Kiểm tra kết nối</a>
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