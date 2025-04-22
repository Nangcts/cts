@extends('master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/nested-catalog/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
@endsection
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Bạn đang sửa phản hồi của khách: <span class="current-name">{{ $feedback->name }}</span></strong>
        </header>
        <div class="panel-body">
          <form method="post" class="form-horizontal" role="form" action = "" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="form-group">
              <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên khách hàng</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptName" value="{!! old('iptName', isset($feedback->name) ? $feedback->name : null) !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptJob" class="col-lg-2 col-sm-2 control-label"><strong>Công việc / Chức vụ</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptJob" value="{!! old('iptJob', isset($feedback->job) ? $feedback->job : null) !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="" class="col-lg-2 col-sm-2 control-label"><strong>Ảnh đại diện</strong></label>
              <div class="col-lg-10">
                <img style="max-width: 75px;" src="{{ asset('upload/filemanager/feedback/' . $feedback->image) }}">
              </div>
            </div>
            <div class="form-group">
              <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Chọn ảnh đại diện mới</strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptAdress" class="col-lg-2 col-sm-2 control-label"><strong>Địa chỉ </strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="text" name="iptAdress" value="{!! old('iptAdress', isset($feedback->adress) ? $feedback->adress : null) !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptSortOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="iptSortOrder" value="{!! old('iptSortOrder', isset($feedback->sort_order) ? $feedback->sort_order : null) !!}">
              </div>
            </div>
            <div class="form-group">
              <label for="txtContent" class="col-lg-2 col-sm-2 control-label"><strong>Nội dung</strong></label>
              <div class="col-lg-10">
                <textarea name="txtContent" rows="5"  class="form-control">{!! old('txtContent', isset($feedback->content) ? $feedback->content : null) !!}</textarea>
              </div>
            </div>                                                    
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">

                <button type="submit" class="btn btn-success " >Lưu   <i class="fa fa-save"></i></button>
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
@section('js')
<script src="{{ asset('js/jquery.nestable.js') }}"></script>
<script>

  $(document).ready(function()
  {

    var updateOutput = function(e)
    {
      var list   = e.length ? e : $(e.target),
      output = list.data('output');
      if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
          } else {
            output.val('JSON browser support required for this demo.');
          }
        };

    // activate Nestable for list 1
    $('#nestable').nestable({
      group: 1
    })
    .on('change', updateOutput);

    // output initial serialised data
    updateOutput($('#nestable').data('output', $('#nestable-output')));

    $('#nestable-menu').on('click', function(e)
    {
      var target = $(e.target),
      action = target.data('action');
      if (action === 'expand-all') {
        $('.dd').nestable('expandAll');
      }
      if (action === 'collapse-all') {
        $('.dd').nestable('collapseAll');
      }
    });
  });
</script>

<script>
  $(document).ready(function(){
    $("#load").hide();

    $('.dd').on('change', function() {
      $("#load").show();

      var dataString = { 
        data : $("#nestable-output").val(),
      };
      var baseURL = window.location.origin;
      var _token = $('input[name = _token]').val();

      $.ajax({
        type: "POST",
        url: baseURL + '/admin/cate/nested-post',
        data: {dataString, _token},
        cache : false,
        success: function(data){
          $("#load").hide();
        } ,error: function(xhr, status, error) {
          alert(error);
        },
      });
    });


    $(document).on("click",".edit-button",function() {
      var id = $(this).attr('id');
      var label = $(this).attr('label');
      var link = $(this).attr('link');
      $("#id").val(id);
      $("#label").val(label);
      $("#link").val(link);
    });


  });

</script>
@endsection