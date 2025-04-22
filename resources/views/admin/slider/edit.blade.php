@extends('master')

@section('content')
<section class="wrapper">
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      {!! Breadcrumbs::render('admin-slider-update') !!}
      <header class="panel-heading">
        <strong>Sửa ảnh slide</strong>
      </header>
    </div>
    <div class="panel-body">
      <form method="POST" class="form-horizontal" role="form"  enctype="multipart/form-data">
        @include('admin.blocks.error')
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

        <div class="form-group">
          <div class="col-lg-10 col-lg-offset-2">
            <img style="margin:10px 0; max-width: 100%;" src="{{ asset('upload/filemanager/slider/'.$slide->slide) }}" alt="">
          </div>
          <label for="iptSlide" class="col-lg-2 col-sm-2 control-label"><strong>Chọn ảnh thay thế</strong></label>
          <div class="col-lg-10">
            <input type = "file" class="form-control" name="iptSlide" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptLink" class="col-lg-2 col-sm-2 control-label"><strong>Link</strong></label>
          <div class="col-lg-10">
            <input type="text" class="form-control" name="iptLink" value="{!! old('iptLink', isset($slide->link) ? $slide->link : null) !!}">
          </div>
        </div>

        <div class="form-group">
          <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
          <div class="col-lg-10">
            <input type="text" class="form-control" name="iptOrder" value="{!! old('iptOrder',!empty($slide) ? $slide->sort_order : null) !!}">
          </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group">
          <div class=" col-lg-12">

            <button type="submit" class="btn btn-success ">Lưu</button>
            <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Quay lại</a></button>

          </div>
        </div>                      

      </form>
    </div>
  </section>

</section>

@endsection('content')                                              