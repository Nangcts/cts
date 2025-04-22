@extends('master')
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
.col-info-post {
}
.panel-body {
    padding-top: 0;
}
</style>
@endsection
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Sửa khối nội dung</strong>
        </header>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            @include('admin.blocks.flash')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <input type="hidden" name="iptPre" value="{{ URL::previous() }}">
            <div class="form-group">
              <label for="iptName" class="col-lg-3 col-sm-3 control-label">Tiêu đề block</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle',isset($block) ? $block['title'] : null) !!}">
              </div>
            </div>
            <div class="form-group">
              <label for="iptName" class="col-lg-3 col-sm-3 control-label">Link</label>
              <div class="col-lg-9">
                <input type="text" class="form-control" name="iptLink" placeholder="" value="{!! old('iptLink',isset($block) ? $block['link'] : null) !!}">
              </div>
            </div>
            @if($block->image)
<!--             <div class="form-group">
              <label class="col-sm-3 control-label col-sm-3">Ảnh</label>
              <div class="col-sm-9">
                <img src="{{ asset('upload/blocks/' . $block->image) }}" style="width:120px;">
              </div>
            </div> -->
            @endif
            <div class="form-group">
              <label class="col-sm-3 control-label col-sm-3">Thay ảnh</label>
              <div class="col-sm-9">
                <!-- <input type="file" class="form-control" name="iptImage" placeholder=""> -->
                <div class="imageupload">
                  <div class="file-tab">
                    <label class="btn btn-default btn-file">
                      <i class="fa fa-folder-open" arial-hidden = "true"></i>
                      <span>Ảnh</span>
                      <input type="file" name="iptImage" >
                    </label>
                    <button type="button" class="btn btn-default">Remove</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label col-sm-3">Nội dung khối</label>
              <div class="col-sm-9">
                <textarea class="form-control ckeditor" name="txtBody" rows="8">{!! old('txtBody',isset($block) ? $block['body'] : null) !!}</textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-lg-10">
                <button type="submit" class="btn btn-danger">Lưu</button>
                <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Hủy</a></button>
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

  @section('js')
<script src="{{ url('assets/dropzone/dropzone.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/dropzone/css/dropzone.css') }}">
<script src="{{ asset('js/bootstrap-imageupload.js') }}"></script>
<script>
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
    $(document).ready(function() {

        $(".seo-item").hide();

        $(document).on('change',function() {

            if($("#seoOptimize").is(':checked'))

$(".seo-item").show();  // checked

else

$(".seo-item").hide();  // unchecked

});
    });
</script>
<script language="javascript" type="text/javascript">
    window.onload = function () {
        var fileUpload = document.getElementById("fileupload");
        fileUpload.onchange = function () {
            if (typeof (FileReader) != "undefined") {
                var dvPreview = document.getElementById("dvPreview");
                dvPreview.innerHTML = "";
                var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
                for (var i = 0; i < fileUpload.files.length; i++) {
                    var file = fileUpload.files[i];
                    if (regex.test(file.name.toLowerCase())) {
                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var img = document.createElement("IMG");
                            img.height = "65";
                            img.width = "65";
                            img.src = e.target.result;
                            dvPreview.appendChild(img);
                        }
                        reader.readAsDataURL(file);
                    } else {
                        alert(file.name + " File ảnh không hợp lệ.");
                        dvPreview.innerHTML = "";
                        return false;
                    }
                }
            } else {
                alert("Trình duyệt của bạn đã cũ, không hỗ trợ tính năng này.");
            }
        }
    };
</script>
@endsection