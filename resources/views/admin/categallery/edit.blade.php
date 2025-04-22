@extends('master')

@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Sửa danh mục ảnh</strong>
                </header>
                <div class="panel-body">
                  <form method="post" class="form-horizontal" role="form" action = "">
                      @include('admin.blocks.error')
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Danh mục cha</strong></label>
                          <div class="col-lg-10">
                          <select class="form-control" name="sltParent">
                              <option value="0">Chọn danh mục cha</option>
                               <?php 
                                  cate_parent($cate_list,0," |--",$cate_edit->parent_id); 
                                ?>
                          </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên danh mục</strong></label>
                          <div class="col-lg-10">
                              <input class="form-control" name="iptName" value="{!! old('iptName',isset($cate_edit->name) ? $cate_edit->name : null) !!}" >
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
                          <div class="col-lg-10">
                              <input type="text" class="form-control" name="iptOrder" value="{!! old('iptOrder',isset($cate_edit->sort_order) ? $cate_edit->sort_order : null) !!}">
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