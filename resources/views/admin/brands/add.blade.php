@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Thêm mới hãng</strong>
                </header>
                <div class="panel-body">
                  <form method="post" class="form-horizontal" role="form" action = "{!! URL('admin/brand/add') !!}" enctype="multipart/form-data">
                      @include('admin.blocks.error')
                      {!! csrf_field() !!}
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên hãng</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptName" value="{!! old('iptName') !!}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Logo hãng</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" name="iptOrderAdd" value="{!! old('iptOrder') !!}">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Mô tả</strong></label>
                          <div class="col-lg-10">
                              <textarea name="txtDes" rows="5"  class="form-control">{!! old('txtDes') !!}</textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Từ khóa</strong></label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" name="iptKeywords" value="{!! old('iptKeywords') !!}">
                          </div>
                      </div>                                                     
                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">

                              <button type="submit" class="btn btn-success " >Lưu</button>
                              <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Quay lại</a></button>
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