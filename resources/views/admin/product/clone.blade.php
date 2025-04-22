@extends('master')

@section('content')
<section class="wrapper">
  <!-- page start-->
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
     {!! Breadcrumbs::render('admin-product-clone') !!}
     <header class="panel-heading">
      <strong>Nhân bản sản phẩm</strong>
    </header>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" role="form" action="{{ route('storeCloneProduct') }}" method="POST" enctype="multipart/form-data">
      @include('admin.blocks.error')
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="prevLink" value="{{ URL::previous() }}">
      <input type="hidden" name="random_temp_id" value="{{ $first_product_id }}">
      <div class="add-post clearfix row">
        <div class="col-lg-8 col-md-8 col-info-post">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Thông tin sản phẩm</h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="sltCatalog" class="control-label">Danh mục </label>  <span class="required-note">(*)</span>
                <div class="">
                  <select class="form-control" name="sltCatalog">
                    <option value="">---</option>
                    <?php cate_parent($catalogs,0," |--", $product->catalog_id); ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="iptName" class="control-label">Tên sản phẩm</label>  <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName', isset($product->name) ? $product->name : null) !!}">
                </div>
              </div>
              <div class="form-group">
                <label for="iptCode" class="control-label">Mã sản phẩm</label>  <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptCode" placeholder="" value="{!! old('iptCode', isset($product->p_code) ? $product->p_code : null) !!}">
                </div>
              </div>
              <div class="form-group">
                <label for="iptSize" class="control-label">Kích thước</label> <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptSize" placeholder="" value="{!! old('iptSize',isset($product->size) ? $product->size : null) !!}">
                </div>
              </div>
              <div class="item-add">
                <label for="iptCustomSlug" class="control-label"><strong>Đường dẫn</strong><br/><span class="help-text" style="font-size: 10px; font-style: italic; color: red">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
                <div>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="customUrl" name="customUrl" @if($product->custom_url == 1) checked @endif>
                      Sử dụng URL thủ công
                    </label>
                  </div>
                  <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{{ old('iptCustomSlug', ($product->custom_url == 1) ? $product->slug : null) }}">
                </div>
              </div>
              <div class="form-group">
                <label for="iptPriceBasic" class="control-label">Giá gốc</label>
                <div class="">
                  <input type="text" class="form-control" name="iptPriceBasic" placeholder="" value="{!! old('iptPriceBasic', isset($product->price_basic) ? $product->price_basic : null) !!}">
                </div>
              </div>

              <div class="form-group">
                <label for="iptPrice" class="control-label">Giá bán</label>  <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptPrice" placeholder="" value="{!! old('iptPrice', isset($product->price) ? $product->price : null) !!}">
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
                  <textarea class="form-control ckeditor" name="txtBody" rows="3">{{ old('txtBody', isset($product->body) ? $product->body : null) }}</textarea>
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
            <h3 class="panel-title">Ảnh sản phẩm</h3>  <span class="required-note">(*)</span>
          </div>
          <div class="panel-body">
 <!--              <div class="form-group">
                <img style="max-width: 125px;" src="{{ asset('upload/filemanager/product/thumbs/' . $product->image) }}">
              </div> -->
              <div class="form-group">
                <label for="iptImage" class="control-label">Ảnh chính</label>
                <div class="">
                  <!-- <input type="file" class="form-control" name="iptImage" placeholder=""> -->
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
              <div class="col-lg-12">

                <div class="form-group">
                  <label>Thêm ảnh</label>
                  <div class="">
                    <div class="dropzone" id="my-dropzone" name="myDropzone">
                    </div>
                  </div>
                </div>

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
                  <label for="iptXuatxu" class="control-label">Xuất xứ</label> <span class="required-note">(*)</span>
                  <div class="">
                    <input type="text" class="form-control" name="iptXuatxu" placeholder="" value="{{ old('iptXuatxu', isset($product->xuat_xu) ? $product->xuat_xu : null) }}">
                  </div>
                </div>
                <!-- <div class="form-group">
                  <label for="iptWarranty" class="control-label">Bảo hành</label> <span class="required-note">(*)</span>
                  <div class="">
                    <input type="text" class="form-control" name="iptWarranty" placeholder="" value="{{ old('iptXuatxu', isset($product->warranty) ? $product->warranty : null) }}">
                  </div>
                </div> -->
              </div>

            </div>
          </div>
         <!--  <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Thiết lập khác</h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="iptChecked" class="control-label"><strong>Trạng thái kho </strong></label>
                <div class="">
                  <div class="radio pull-left" style="margin-right: 15px;">
                    <label>
                      <input name="radioNew" id="radioNew" value="1"  type="radio" @if($product->visible == 1) checked @endif>
                      Còn hàng
                    </label>
                  </div>
                  <div class="radio pull-left">
                    <label>
                      <input name="radioNew" id="radioNew" value="0"  type="radio"  @if($product->visible == 0) checked @endif>
                      Hết hàng
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="radioSticky" class="control-label"><strong>Ghim lên đầu trang </strong></label>
                <div class="">
                  <div class="radio pull-left" style="margin-right: 15px;">
                    <label>
                      <input name="radioSticky" id="radioSticky" value="1"  type="radio"  @if($product->sticky == 1) checked @endif>
                      có
                    </label>
                  </div>
                  <div class="radio pull-left">
                    <label>
                      <input name="radioSticky" id="radioSticky" value="0"  type="radio" @if($product->sticky == 0) checked @endif>
                      Không
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="radioSale" class="control-label"><strong>Khuyến mại </strong></label>
                <div class="">
                  <div class="radio pull-left" style="margin-right: 15px;">
                    <label>
                      <input name="radioSale" id="radioSale" value="1"  type="radio" @if($product->sale == 1) checked @endif>
                      có
                    </label>
                  </div>
                  <div class="radio pull-left">
                    <label>
                      <input name="radioSale" id="radioSale" value="0"  type="radio" @if($product->sale == 0) checked @endif>
                      Không
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div> -->
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Cấu hình SEO</h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="iptSeoTitle" class="control-label">Tiêu đề SEO</label>
                <div class="">
                  <input type="text" class="form-control" name="iptSeoTitle" placeholder="" value="{!! old('iptSeoTitle', isset($product->seo_title) ? $product->seo_title : null) !!}">
                </div>
              </div>
              <div class="form-group">
                <label for="iptKeywords" class="control-label">Từ khóa SEO</label>
                <div class="">
                  <input type="text" class="form-control" name="iptKeywords" placeholder="" value="{!! old('iptKeywords', isset($product->keywords) ? $product->keywords : null) !!}">
                </div>
              </div>
              <div class="form-group">
                <label for="txtDes" class="control-label">Mô tả SEO</label>
                <div class="">
                  <textarea class="form-control" name="txtDes" rows="6">{!! old('txtDes', isset($product->des) ? $product->des : null) !!}</textarea>
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
</section>
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

  .gallery a.image_link {
    width: 100%;
  }
  .gallery li.ui-sortable-handle {
    border: 1px solid #ccc;
    cursor: move;
    padding: 5px;
    position: relative;
  }
  .image_link > img {
  }
  .gallery .delete-img {
    cursor: pointer;
  }

</style>
@endsection