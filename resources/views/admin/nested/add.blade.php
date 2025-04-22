@extends('master')

@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Thêm mới danh mục sản phẩm</strong>
                </header>
                <div class="panel-body">
                  <form method="post" class="form-horizontal" role="form" action = "{!! URL('admin/catalog/add') !!}">
                      @include('admin.blocks.error')
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Danh mục cha</strong></label>
                          <div class="col-lg-10">
                          <select class="form-control" name="sltParentAdd">
                              <option value="0">Chọn danh mục cha</option>
                               <?php 
                                  cate_parent($catalog_list,0," |--",0); 
                                ?>
                          </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên danh mục</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptNameAdd" value="{!! old('iptName') !!}" >
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" name="iptOrderAdd" value="{!! old('iptOrder') !!}">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptKeywords" class="col-lg-2 col-sm-2 control-label"><strong>Từ khóa SEO</strong></label>
                          <div class="col-lg-10">
                              <textarea name="txtKeywords" rows="3"  class="form-control">{!! old('iptKeywords') !!}</textarea>
                          </div>
                      </div>  
                      <div class="form-group">
                          <label for="iptDes" class="col-lg-2 col-sm-2 control-label"><strong>Mô tả SEO</strong></label>
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