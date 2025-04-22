@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <div class="col-lg-12 header-page-admin">
            {!! Breadcrumbs::render('admin-video-create') !!}
            <header class="panel-heading">
                <strong>Thêm mới Video</strong>
            </header>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" action="{{ route('updateVideo', $video->id) }}" method="POST" enctype="multipart/form-data">
                @include('admin.blocks.error')
                @csrf
                <div class="add-post clearfix row">
                    <div class="col-lg-8 col-md-8 col-info-post">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Nhập thông tin</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="iptTitle" class="control-label">Tiêu đề Video</label> <span class="required-note">(*)</span>
                                        <div class="">
                                            <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle', isset($video->title) ? $video->title : null) !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="iptLink" class="control-label">Link Video</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="iptLink" placeholder="Nhập link Youtube" value="{!! old('iptLink', isset($video->link) ? $video->link : null) !!}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="iptCustomSlug" class="control-label"><strong>Đường dẫn</strong><br/><span class="help-text" style="font-size: 10px; font-style: italic; color: red">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
                                        <div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="customUrl" name="customUrl">
                                                    Sử dụng URL thủ công
                                                </label>
                                            </div>
                                            <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{!! old('iptCustomSlug') !!}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Col-lg-6 -->
                    <div class="col-lg-4 col-md-4 col-extra-post">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Tùy chọn xuất bản</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i>  Lưu</button>
                                        <button type="button"  class="btn btn-success"><a href="{{ URL::previous() }}" style="color: #fff"><i class="fa fa-step-backward" ></i>  Quay lại</a></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Cấu hình SEO</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="iptSeoTitle" class="control-label">Tiêu đề SEO</label>
                                        <div class="">
                                            <input type="text" class="form-control" name="iptSeoTitle" placeholder="" value="{!! old('iptSeoTitle', isset($video->seo_title) ? $video->seo_title : null) !!}">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-lg-12">
                                        <label for="txtDes" class="control-label">Mô tả SEO</label>
                                        <div class="">
                                            <textarea class="form-control" name="txtDes" rows="6">{!! old('txtDes', isset($video->seo_des) ? $video->seo_des : null) !!}</textarea>
                                        </div>
                                    </div>
                                </div>         
                            </div>
                        </div>         
                    </div>
                    <!-- End Col-lg-6 -->
                </div>
                <div class="save-post clearfix">
                    <div class="col-lg-12 save-post-button">
                        <button type="submit" class="btn btn-success "><i class="fa fa-save"></i>  Lưu</button>
                        <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}"><i class="fa fa-step-backward"></i>  Quay lại</a></button>
                    </div>
                </div>  
            </form> 
        </div>
        <!-- page end-->
    </section>
</section>
@endsection('content')