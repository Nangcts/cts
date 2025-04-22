@extends('master')

@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thêm mới danh mục bài viết</strong>
        </header>
        <div class="panel-body">
          <form method="post" class="form-horizontal" role="form" action = "{!! URL('admin/cate/add') !!}" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="form-group">
              <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Danh mục cha</strong></label>
              <div class="col-lg-10">
                <select class="form-control" name="sltParentAdd">
                  <option value="0">Chọn danh mục cha</option>
                  <?php 
                  cate_parent($cate_list,0," |--",0); 
                  ?>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="iptNameAdd" class="col-lg-2 col-sm-2 control-label"><strong>Tên danh mục</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptNameAdd" value="{!! old('iptName') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptCustomSlug" class="col-lg-2 col-sm-2 control-label">Đường dẫn<br/><span class="help-text" style="font-size: 10px; font-style: italic;">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
              
              <div class="col-lg-10">
                <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{!! old('iptCustomSlug') !!}">
              </div>
            </div>
            <div class="form-group">
              <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Ảnh đại diện</strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptChecked" class="col-lg-2 col-sm-2 control-label"><strong>Menu top </strong></label>
              <div class="col-lg-10">
                <div class="radio pull-left" style="margin-right: 15px;">
                  <label>
                    <input name="optionsRadiosMenu" id="optionsRadios1" value="1"  type="radio">
                    có
                  </label>
                </div>
                <div class="radio pull-left">
                  <label>
                    <input name="optionsRadiosMenu" id="optionsRadios1" value="0" checked  type="radio">
                    Không
                  </label>
                </div>
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