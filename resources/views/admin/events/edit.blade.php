@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        {!! Breadcrumbs::render('admin-event-edit') !!}
        <header class="panel-heading">
          <strong>Sửa Bài viết</strong>
        </header>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="add-post clearfix row">
              <div class="col-lg-8 col-md-8 col-info-post">
                <div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title"><strong>Sửa nội dung sự kiện đã làm</strong></h3>
                  </div>
                  <div class="panel-body">

                    <div class="item-add">
                      <label for="iptName" class="control-label"><strong>Tiêu đề sự kiện</strong></label>
                      <div>
                        <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle', isset($event->title) ? $event->title : null) !!}">
                      </div>
                    </div>  

                    <div class="item-add">
                      <label class="control-label"><strong>Mô tả ngắn</strong></label>
                      <div class="">
                        <textarea class="form-control" name="txtIntro" rows="6">{!! old('txtIntro', isset($event->intro) ? $event->intro : null) !!}</textarea>
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
                    @if (!empty($event->image))    
                    <div class="item-add">
                      <label for="" class="control-label">Ảnh hiện tại</label>
                      <div class="">
                        <img style="width:75px; height:75px" src="{!! asset('upload/filemanager/event/'.$event->image) !!}" alt="Ảnh đại diện">
                      </div>
                    </div>   
                    @endif
                    <div class="item-add">
                      <label for="iptImage" class="control-label">Chọn ảnh mới</label>
                      <div class="">
                        <input type="file" class="form-control" name="iptImage" placeholder="">
                      </div>
                    </div>
                  </div>
                </div>
                <di>
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
    </div>
  </div>
  <!-- page end-->
</section>

@endsection('content')
@section('js')
<script type="text/javascript">
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
</script>
@endsection