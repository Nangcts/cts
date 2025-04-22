@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        {!! Breadcrumbs::render('admin-feedback-create') !!}
        <header class="panel-heading">
          <strong>Thêm mới FeedBack khách hàng</strong>
        </header>
        <div class="panel-body">
          <form method="post" class="form-horizontal" role="form" action = "{!! URL('admin/feedback/add') !!}" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="form-group">
              <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên khách hàng</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptName" value="{!! old('iptName') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptJob" class="col-lg-2 col-sm-2 control-label"><strong>Công việc / Chức vụ</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptJob" value="{!! old('iptJob') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Ảnh đại diện</strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptAdress" class="col-lg-2 col-sm-2 control-label"><strong>Địa chỉ </strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="text" name="iptAdress" value="{!! old('iptAdress') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptSortOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="iptSortOrder" value="{!! old('iptSortOrder') !!}">
              </div>
            </div>
            <div class="form-group">
              <label for="txtContent" class="col-lg-2 col-sm-2 control-label"><strong>Nội dung</strong></label>
              <div class="col-lg-10">
                <textarea name="txtContent" rows="5"  class="form-control">{!! old('txtContent') !!}</textarea>
              </div>
            </div>                                                    
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">

                <button type="submit" class="btn btn-success " >Lưu   <i class="fa fa-save"></i></button>
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