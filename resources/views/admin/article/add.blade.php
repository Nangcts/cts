@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <div class="col-lg-12 header-page-admin">
            {!! Breadcrumbs::render('admin-article-create') !!}
            <header class="panel-heading">
                <strong>Thêm mới Bài viết</strong>
            </header>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">
                @include('admin.blocks.error')
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="add-post clearfix row">
                    <div class="col-lg-8 col-md-8 col-info-post">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Nội dung bài viết</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="item-add">
                                    <label for="sltcate" class="control-label"><strong>Danh mục</strong></label>
                                    <div class="">
                                        <select class="form-control" name="sltcate">
                                            <option value="">Chọn danh mục cha</option>
                                            <?php 
                                            cate_parent($cate_list,0," |--",0); 
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="item-add">
                                    <label for="iptName" class="control-label"><strong>Tiêu đề bài viết</strong></label>
                                    <div>
                                        <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle') !!}">
                                    </div>
                                </div>  
                                <div class="item-add">
                                    <label for="iptCustomSlug" class="control-label"><strong>Đường dẫn</strong><br/><span class="help-text" style="font-size: 10px; font-style: italic;">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
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
                                <div class="item-add">
                                    <label class="control-label"><strong>Mô tả ngắn</strong></label>
                                    <div class="">
                                        <textarea class="form-control" name="txtIntro" rows="6">{!! old('txtIntro') !!}</textarea>
                                    </div>
                                </div>
                                <div class="item-add">
                                    <label for="txtBody" class="control-label"><strong>Nội dung chính</strong></label>
                                    <div class="">
                                        <textarea class="form-control ckeditor" name="txtBody" rows="7">{!! old('txtBody') !!}</textarea>
                                    </div>   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-extra-post">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Ảnh đại diện</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="item-add">
                                    <label for="iptImage" class="control-label">Ảnh</label>
                                    <div class="">
                                        <input type="file" class="form-control" name="iptImage" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Video Url</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="item-add">
                                    <div class="">
                                        <input id="iptVideo" type="text" class="form-control" name="iptVideo" placeholder="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sản phẩm liên quan</h3>
                            </div>
                            <div class="panel-body">
                                <div class="item-add">
                                    <select class="form-control sltProductReferences" multiple="multiple" name="sltProductReferences[]">
                                        @foreach (App\Product::orderBy('created_at','desc')->get() as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Cấu hình SEO</strong></h3>
                            </div>
                            <div class="panel-body">
                                <div class="item-add seo-item">
                                    <label for="iptSeoTitle" class="control-label"><strong>Tiêu đề SEO</strong></label>
                                    <div class="">
                                        <input type="text" class="form-control" name="iptSeoTitle" value="{{ old('iptSeoTitle') }}" placeholder="">
                                    </div>
                                </div>

                                <div class="item-add seo-item">
                                    <label for="txtDes" class="control-label"><strong>Mô tả SEO</strong></label>
                                    <div class="">
                                        <textarea class="form-control" name="txtDes" rows="6">{{ old('txtDes') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item-add">
                  <div class=" col-lg-12">
                      <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}"><i class="fa fa-forward"></i>   Quay lại</a></button>
                      <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i>   Lưu</button>
                  </div>
              </div>
          </form>

      </div>
  </section>
  <!-- page end-->
</section>

@endsection('content')
@section('js')
<script type="text/javascript">
    $(document).ready(function() {

        $(".sltProductReferences").select2({
            minimumResultsForSearch: Infinity,
            maximumSelectionLength: 5,
            placeholder: 'Chọn tối đa 5 sản phẩm',
        });
        $('#iptTags').selectize({
            plugins: ['remove_button'],
            delimiter: ',',
            persist: false,
            create: function(input) {
                return {
                    value: input,
                    text: input
                }
            }
        });
    });
</script>
@endsection