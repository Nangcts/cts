extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Bạn đăng sửa Visa: <span class="current-name">{{ $visa->name }}</span></strong>
                </header>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">
                  @include('admin.blocks.error')
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-group">
                        <label for="sltcate" class="col-lg-3 col-sm-3 control-label"><strong>Danh mục</strong></label>
                        <div class="col-lg-9">
                            <select class="form-control" name="sltCate">
                              <option value="">Chọn danh mục</option>
                               <?php 
                                  cate_parent($list_cate,0," |--",$visa->cate_id); 
                                ?>
                          </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Tiêu đề</strong></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName', isset($visa) ? $visa->name : null) !!}">
                        </div>
                    </div>  
                                 
                    <div class="form-group">
                        <label for="iptImage" class="col-lg-3 col-sm-3 control-label"><strong>Ảnh</strong></label>
                        <div class="col-lg-9">
                            <input type="file" class="form-control" name="iptImage" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="iptPrice" class="col-lg-3 col-sm-3 control-label"><strong>Giá dịch vụ</strong></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="iptPrice" placeholder="" value="{{ old('iptPrice', isset($visa) ? $visa->price : null) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="iptOrder" class="col-lg-3 col-sm-3 control-label"><strong>Thứ tự</strong></label>
                        <div class="col-lg-9">
                            <input type="text" class="form-control" name="iptOrder" placeholder="" value="{{ old('iptOrder', isset($visa) ? $visa->order : null) }}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-3 control-label col-sm-3"><strong>Mô tả ngắn</strong></label>
                        <div class="col-sm-9">
                            <textarea class="form-control" name="txtIntro" rows="6">{!! old('txtIntro', isset($visa) ? $visa->intro : null) !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="txtKeywords" class="col-lg-3 col-sm-3 control-label"><strong>Từ khóa SEO</strong></label>
                        <div class="col-lg-9">
                            <textarea class="form-control" name="txtKeywords" rows="3">{!! old('txtKeywords', isset($visa) ? $visa->keywords : null) !!}</textarea>
                        </div>
                    </div>

                    <div class="form-group">
                            <label for="txtBody" class="col-lg-2 col-sm-12 control-label"><strong>Nội dung chính</strong></label>
                            <div class="col-lg-10">
                                <textarea class="form-control ckeditor" name="txtBody" rows="7">{!! old('txtBody', isset($visa) ? $visa->body : null) !!}</textarea>
                            </div>   
                    </div>
                    <div class="form-group">
                          <div class=" col-lg-11">
                              <button type="button"  class="btn btn-default pull-right"><a href="{{ URL::previous() }}">Quay lại</a></button>
                              <button type="submit" class="btn btn-danger pull-right">Lưu</button>
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