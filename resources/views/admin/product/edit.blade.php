@extends('master')

@section('content')
<section class="wrapper">
  <!-- page start-->
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
     {!! Breadcrumbs::render('admin-product-edit') !!}
     <header class="panel-heading">
      <strong>Cập nhật sản phẩm</strong>
    </header>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" role="form" action="{{ route('admin.product.postEdit',$product->id) }}" method="POST" enctype="multipart/form-data">
      @include('admin.blocks.error')
      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
      <input type="hidden" name="prevLink" value="{{ URL::previous() }}">
      <div class="add-post clearfix row">
        <div class="col-lg-8 col-md-8 col-info-post">
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">Thông tin sản phẩm</h3>
            </div>
            <div class="panel-body">
              <div class="form-group">
                <label for="iptName" class="control-label">Tên sản phẩm</label>  <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName', isset($product->name) ? $product->name : null) !!}">
                </div>
              </div>

              <div class="form-group">
                <label for="iptGift" class="control-label">Quà tặng</label> 
                <div class="">
                  <input type="text" class="form-control" name="iptGift" placeholder="" value="{!! old('iptGift',isset($product->sale_content)?$product->sale_content : null) !!}">
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
                  <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{{ old('iptCustomSlug', isset($product->slug) ? $product->slug : null) }}">
                </div>
              </div>
              
              <div class="form-group">
                <label for="iptPrice" class="control-label">Đơn giá</label> <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptPrice" placeholder="" value="{!! old('iptPrice', isset($product->price) ? $product->price : null) !!}">
                </div>
              </div>


              <div class="form-group">
                <label for="iptSalePrice" class="control-label">Giá khuyến mãi</label>  <span class="required-note">(*)</span>
                <div class="">
                  <input type="text" class="form-control" name="iptSalePrice" placeholder="" value="{!! old('iptSalePrice', isset($product->sale_price) ? $product->sale_price : null) !!}">
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
                  <textarea class="form-control ckeditor" name="txtIntro" rows="3">{{ old('txtIntro',$product->intro) }}</textarea>
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
            <label class="panel-title">Lựa chọn Danh mục</label>   <span class="required-note">(*)</span>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <div class="category-wrap">
                <ul>
                  @if($categories)
                  <?php
                  $categories_collect = DB::table('category_product')->select('category_id')->where('product_id', $product->id)->get();
                  ?>
                  @foreach ($categories as $item)
                  <?php $sub_lv1 = App\Category::where('parent_id', $item->id)->orderBy('sort_order','asc')->get() ?>
                  <li class="category-item root-item">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="chkCategory[]" value="{{ $item->id }}" @if($categories_collect->contains('category_id', $item->id)) checked @endif>
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
                            <input type="checkbox" name="chkCategory[]" value="{{ $sub_item->id }}" @if($categories_collect->contains('category_id', $sub_item->id)) checked @endif>
                            {{ $sub_item->name }}
                          </label>
                        </div>
                        @if($sub_lv2->first())
                        <ul class="sub_category">
                          @foreach ($sub_lv2 as $sub_item_2)
                          <li class="category-item sub-item-2">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" name="chkCategory[]" value="{{ $sub_item_2->id }}" @if($categories_collect->contains('category_id', $sub_item_2->id)) checked @endif>
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
            <h3 class="panel-title">Ảnh sản phẩm</h3>  <span class="required-note">(*)</span>
          </div>
          <div class="panel-body">
            <div class="form-group">
              <img style="max-width: 125px;" src="{{ asset('upload/filemanager/product/thumbs/' . $product->image) }}">
            </div>
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
                    <button type="button" class="btn btn-default">Remove</button>
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

              <div class="form-group">
                <label>Quản lý ảnh</label>
                <div class="gallery-reorder-manager">
                  <?php $gallerys = DB::table('product_images')->where('product_id',$product->id)->orderBy('sort_order','asc')->get() ?>

                  <div>
                    <a href="javascript:void(0);" class="btn outlined mleft_no reorder_link" id="">Sắp xếp ảnh</a>
                    <div id="reorder-helper" class="light_box" style="display:none;">1. Kéo thả để xếp lại ảnh.<br>2. Click 'Lưu sắp xếp'.</div>
                    <div class="gallery">
                      <ul class="reorder_ul reorder-photos-list">
                        @if(!empty($gallerys))
                        @foreach($gallerys as $item)
                        <li id="image_li_{{ $item->id }}" class="ui-sortable-handle col-lg-3 col-md-3 col-sm-3 col-xs-4">
                          <div class="inner">
                            <a href="javascript:void(0);" style="float:none;" class="image_link">
                              <img style="width:100%; height: auto" src="{{ asset('upload/filemanager/product/gallery/'.$item->image) }}" alt="">
                            </a>
                            <span class="delete-img" id = "{{ $item->id }}"  onclick="return confirmdelete('Xóa bỏ ảnh này?')" ><i class="fa fa-remove"></i></span>
                          </div>
                        </li>
                        @endforeach
                        @endif
                      </ul>
                    </div>
                  </div>
                </div>
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
                <option>Chọn bài viết liên quan</option>
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
              <label for="iptXuatxu" class="control-label">Tình trạng hàng</label> <span class="required-note">(*)</span>
              <div class="">
                <div class="radio">
                  <label style="margin-right: 15px;">
                    <input type="radio" name="rdoStatus" id="input" value="1" @if($product->status == 1) checked="checked" @endif>
                    Còn hàng
                  </label>
                  <label>
                    <input type="radio" name="rdoStatus" id="input" value="0" @if($product->status == 0) checked="checked" @endif>
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
                    <input type="radio" name="rdoHot" id="input" value="1" @if($product->hot == 1) checked="checked" @endif>
                    Có
                  </label>
                  <label>
                    <input type="radio" name="rdoHot" id="input" value="0" @if($product->hot == 0) checked="checked" @endif>
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
                    <input type="radio" name="rdoOffer" id="input" value="1" @if($product->offer == 1) checked="checked" @endif>
                    Có
                  </label>
                  <label>
                    <input type="radio" name="rdoOffer" id="input" value="0" @if($product->offer == 0) checked="checked" @endif>
                    Không
                  </label>
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
</section>
<!-- page end-->
</section>
@endsection('content')
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="{{ url('assets/dropzone/dist/dropzone.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dropzone/dist/dropzone.css') }}">
<script src="{{ asset('js/bootstrap-imageupload.js') }}"></script>
<style>
  .dropzone, .gallery {
    border: 2px dashed #0087F7;
    border-radius: 5px;
    background: white;
    margin-bottom: 15px;
    overflow: hidden;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $("#mytable").on('click','.remove-price',function() {
      $(this).parent().parent().remove();
    });
    var article_id = {{ json_encode($article_id) }};
    $(".sltPostReferences").select2().val(article_id).trigger('change.select2');
    $('.sltPostReferences').select2({
      maximumSelectionLength: 5,
      placeholder: 'Chọn tối đa 5 Bài viết',
    });
  });
  Dropzone.options.myDropzone= {
    url: "{{ route('admin.product.DropzoneUploadImg', $id) }}",
    headers: {
     'X-CSRF-TOKEN': '{!! csrf_token() !!}'
   },
   autoProcessQueue: true,
   uploadMultiple: true,
   parallelUploads: 5,
   maxFiles: 10,
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
      alert(data);
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
<script>
  $(document).ready(function() {
    $('span.delete-img').on('click', function() {
      var _token = "{{ csrf_token() }}";
      var id = $(this).attr('id');
      $.ajax({
        type: "GET",
        url: "/admin/product/delete-img",
        data: {
          "_token": _token,
          "id": id,
        },
        success: function (data) {
          $('#image_li_' + id).remove();
        }
      });
    });
  });
</script>
<script>
  // $(document).ready(function() {
  //   $('#iptTags').selectize({
  //     plugins: ['remove_button'],
  //     delimiter: ',',
  //     persist: false,
  //     create: function(input) {
  //       return {
  //         value: input,
  //         text: input
  //       }
  //     }
  //   });
  // });
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
<script>
  $(document).ready(function(){
    $('.reorder_link').on('click',function(){
      $("ul.reorder-photos-list").sortable({ tolerance: 'pointer' });
      $('.reorder_link').html('Lưu sắp xếp');
      $('.reorder_link').attr("id","save_reorder");
      $('#reorder-helper').slideDown('slow');
      $('.image_link').attr("href","javascript:void(0);");
      $('.image_link').css("cursor","move");
      $("#save_reorder").click(function( e ){
        if( !$("#save_reorder i").length ){
          $(this).html('').prepend('<img src="{{ asset('images/refresh-animated.gif') }}"/>');
          $("ul.reorder-photos-list").sortable('destroy');
          $("#reorder-helper").html( "Đăng xếp lại ảnh, vui lòng không thao tác gì khác cho đến khi hoàn thành !" ).removeClass('light_box').addClass('notice notice_error');

          var _token = "{{ csrf_token() }}";
          var h = [];
          $("ul.reorder-photos-list li").each(function() {  h.push($(this).attr('id').substr(9));  });                
          $.ajax({
            type: "POST",
            url: "/admin/product/reorder",
            data: {ids: h , _token: _token},
            success: function(){
              $("#reorder-helper").html( "Sắp xếp hoàn thành !" ).removeClass('notice_error').addClass('success-reoder bg-success');
              window.location.reload();
            }
          }); 
          return false;
        }   
        e.preventDefault();     
      });
    });
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