@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Thêm mới Gallery ảnh</strong>
                </header>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
                  @include('admin.blocks.error')
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                        <div class="form-group">
                            <label for="sltCatalog" class="col-lg-2 col-sm-3 control-label"><strong>Danh mục</strong></label>
                            <div class="col-lg-10">
                                <select class="form-control" name="sltCate">
                                  <option value="">Chọn danh mục</option>
                                   <?php 
                                      cate_parent($cate_gallery,0," |--",0); 
                                    ?>
                              </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="iptName" class="col-lg-2 col-sm-3 control-label"><strong>Tên album<strong></label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="iptName" placeholder="" value="{{ old('iptName') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="" class="col-lg-2 col-sm-3 control-label"><strong>Tải ảnh<strong></label>
                            <div class="col-lg-10">
                                <input type="file" class="form-control" name="iptAlbum[]" placeholder="Upload tài liệu" value="" multiple="true">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label col-sm-3"><strong>Mô tả ngắn<strong></label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="txtIntro" rows="6">{{old('txtIntro')}}</textarea>
                            </div>
                        </div>

                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-danger">Lưu</button>
                              <button type="reset"  class="btn btn-default">Reset</button>
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