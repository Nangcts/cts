@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <section class="panel">
        <div class="col-lg-12 header-page-admin">
            {!! Breadcrumbs::render('admin-product-create') !!}
            <header class="panel-heading">
                <strong>Thêm mới sản phẩm</strong>
            </header>
        </div>
        <div class="panel-body">
         <form class="form-horizontal" role="form" action="{{ route('admin.product.post') }}" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="random_temp_id" value="{{ $first_product_id }}">
            <div class="add-post clearfix row">
                <div class="col-lg-8 col-md-8 col-info-post">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Thông tin cơ bản</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="iptName" class="control-label">Tên sản phẩm</label> <span class="required-note">(*)</span>
                                <div class="">
                                    <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName') !!}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="iptGift" class="control-label">Quà tặng</label>
                                <div class="">
                                    <input type="text" class="form-control" name="iptGift" placeholder="" value="{!! old('iptGift') !!}">
                                </div>
                            </div>

                            <div class="item-add">
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
                            
                            <div class="form-group">
                                <label for="iptPrice" class="control-label">Đơn giá</label> <span class="required-note">(*)</span>
                                <div class="">
                                    <input type="text" class="form-control" name="iptPrice" placeholder="" value="{!! old('iptPrice') !!}">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="iptSalePrice" class="control-label">Giá khuyến mãi</label>
                                <div class="">
                                    <input type="text" class="form-control" name="iptSalePrice" placeholder="" value="{!! old('iptSalePrice') !!}">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Mô tả ngắn về sản phẩm</h3>
                        </div>
                        <div class="panel-body">
                            <div class="">
                                <div class="">
                                    <textarea class="form-control ckeditor" name="txtIntro" rows="3">{{ old('txtIntro') }}</textarea>
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Chi tiết sản phẩm</h3>
                        </div>
                        <div class="panel-body">
                            <div class="">

                                <div class="">
                                    <textarea class="form-control ckeditor" name="txtBody" rows="3">{{ old('txtBody') }}</textarea>
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

                                <div class="">
                                 <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i>  Lưu</button>
                                 <button type="button"  class="btn btn-success"><a href="{{ URL::previous() }}" style="color: #fff"><i class="fa fa-step-backward" ></i>  Quay lại</a></button>
                             </div>
                         </div>

                     </div>
                 </div>
                 <div class="panel panel-info">
                    <div class="panel-heading">
                        <label class="panel-title">Lựa chọn Danh mục</label>   <span class="required-note">(*)</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="category-wrap">
                                <ul>
                                    @if($categories)
                                    @foreach ($categories as $item)
                                    <?php $sub_lv1 = App\Category::where('parent_id', $item->id)->orderBy('sort_order','asc')->get() ?>
                                    <li class="category-item root-item">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="chkCategory[]" value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                        @if($sub_lv1->first())
                                        <ul class="sub_category">
                                            @foreach ($sub_lv1 as $sub_item)
                                            <?php $sub_lv2 = App\Category::where('parent_id', $sub_item->id)->orderBy('sort_order','asc')->get() ?>
                                            <li class="category-item sub-item-1">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="chkCategory[]" value="{{ $sub_item->id }}">
                                                        {{ $sub_item->name }}
                                                    </label>
                                                </div>
                                                @if($sub_lv2->first())
                                                <ul class="sub_category">
                                                    @foreach ($sub_lv2 as $sub_item_2)
                                                    <li class="category-item sub-item-2">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name="chkCategory[]" value="{{ $sub_item_2->id }}">
                                                                {{ $sub_item_2->name }}
                                                            </label>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                @endif
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ảnh đại diện sản phẩm</h3>  <span class="required-note">(*)</span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">

                            <div class="">
                                <div class="imageupload">
                                    <div class="file-tab">
                                        <label class="btn btn-primary btn-file">
                                            <i class="fa fa-folder-open" arial-hidden = "true"></i>
                                            <span>Ảnh đại diện</span>
                                            <input type="file" name="iptImage" >
                                        </label>
                                        <button type="button" class="btn btn-danger">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Ảnh chi tiết</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="dropzone" id="my-dropzone" name="myDropzone">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Bài viết liên quan</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <select class="form-control sltPostReferences" multiple="multiple" name="sltPostReferences[]">

                                @foreach (App\Article::orderBy('created_at','desc')->get() as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Thuộc tính sản phẩm</h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="iptXuatxu" class="control-label">Tình trạng hàng</label> <span class="required-note">(*)</span>
                                <div class="">
                                    <div class="radio">
                                        <label style="margin-right: 15px;">
                                            <input type="radio" name="rdoStatus" id="input" value="1" checked="checked">
                                            Còn hàng
                                        </label>
                                        <label>
                                            <input type="radio" name="rdoStatus" id="input" value="0">
                                            Hết hàng
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="iptXuatxu" class="control-label">Sản phẩm hot</label> <span class="required-note">(*)</span>
                                <div class="">
                                    <div class="radio">
                                        <label style="margin-right: 15px;">
                                            <input type="radio" name="rdoHot" id="input" value="1" >
                                            Có
                                        </label>
                                        <label>
                                            <input type="radio" name="rdoHot" id="input" value="0" checked="checked">
                                            Không
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rdoOffer" class="control-label">Sản phẩm giới thiệu</label> <span class="required-note">(*)</span>
                                <div class="">
                                    <div class="radio">
                                        <label style="margin-right: 15px;">
                                            <input type="radio" name="rdoOffer" id="input" value="1" >
                                            Có
                                        </label>
                                        <label>
                                            <input type="radio" name="rdoOffer" id="input" value="0" checked="checked">
                                            Không
                                        </label>
                                    </div>
                                </div>
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
                            <label for="iptSeoTitle" class="control-label">Tiêu đề SEO</label>
                            <div class="">
                                <input type="text" class="form-control" name="iptSeoTitle" placeholder="" value="{!! old('iptSeoTitle') !!}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="txtDes" class="control-label">Mô tả SEO</label>
                            <div class="">
                                <textarea class="form-control" name="txtDes" rows="6">{!! old('txtDes') !!}</textarea>
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

</div>
<!-- page end-->
</section>

@endsection('content')
@section('js')
<script src="{{ url('assets/dropzone/dist/dropzone.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dropzone/dist//dropzone.css') }}">
<link rel="stylesheet" href="{{ asset('assets/simple-tree/simTree.css') }}">

<script src="{{ asset('js/bootstrap-imageupload.js') }}"></script>
<script src="{{ asset('assets/simple-tree/simTree.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".js-select2").select2({
            closeOnSelect : false,
            placeholder : "Placeholder",
            allowHtml: true,
            allowClear: true,
            tags: true
        });
        $(".sltPostReferences").select2({
            minimumResultsForSearch: Infinity,
            maximumSelectionLength: 5,
            placeholder: 'Chọn tối đa 5 bài viết',
        });
    });
    var temp_id = $("input[name='random_temp_id']").val();
    Dropzone.options.myDropzone= {
     url: "/admin/product/dropzone-uploadImg/" + temp_id,
     headers: {
         'X-CSRF-TOKEN': '{!! csrf_token() !!}'
     },
     autoProcessQueue: true,
     uploadMultiple: true,
     parallelUploads: 5,
     maxFiles: 20,
     maxFilesize: 5,
     acceptedFiles: ".jpeg,.jpg,.png,.gif",
     dictFileTooBig: 'Image is bigger than 5MB',
     addRemoveLinks: true,
     removedfile: function(file) {
         var name = file.name;    
         name =name.replace(/\s+/g, '-').toLowerCase();    /*only spaces*/
         $.ajax({
            type: 'POST',
            url: '{{ route('admin.product.deleteDropzoneImg') }}',
            headers: {
               'X-CSRF-TOKEN': '{!! csrf_token() !!}'
           },
           data: "id="+name,
           dataType: 'html',
           success: function(data) {
            $("#msg").html(data);
        }
    });
         var _ref;
         if (file.previewElement) {
            if ((_ref = file.previewElement) != null) {
              _ref.parentNode.removeChild(file.previewElement);
          }
      }
      return this._updateMaxFilesReachedClass();
  },
  previewsContainer: null,
  hiddenInputContainer: "body",
}
</script>
<style>
    .dropzone {
        border: 2px dashed #0087F7;
        border-radius: 5px;
        background: white;
    }
</style>
<script>
    $(document).ready(function() {
        $("#mytable").on('click','.remove-price',function() {
            $(this).parent().parent().remove();
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
    var $imageupload = $('.imageupload');
    $imageupload.imageupload();

    $('#imageupload-disable').on('click', function() {
        $imageupload.imageupload('disable');
        $(this).blur();
    })

    $('#imageupload-enable').on('click', function() {
        $imageupload.imageupload('enable');
        $(this).blur();
    })

    $('#imageupload-reset').on('click', function() {
        $imageupload.imageupload('reset');
        $(this).blur();
    });
</script>

@endsection
@section('css')
<link href="{{ asset('css/bootstrap-imageupload.css') }}" rel="stylesheet">
<style>
    .category-item {
        float: left;
        padding-right: 10px;
        margin-bottom: 25px;
    }
    .btn-file input[type="file"] {
        cursor: inherit;
        height: 100%;
        opacity: 0;
        width: 100%;
    }
    #dvPreview > img {
        border: 1px solid #f5f5f5;
        margin: 0 5px;
    }
    .col-extra-post .form-group, .col-info-post .form-group {
        margin: 0;
    }
    .btn.btn-default.btn-file {
        height: 35px;
        width: 105px;
    }
    .panel-body {
        padding-top: 0;
    }
</style>
@endsection