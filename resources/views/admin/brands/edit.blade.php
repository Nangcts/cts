@extends('master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('public/assets/nested-catalog/style.css') }}">
<link rel="stylesheet" href="{{ asset('public/assets/font-awesome/css/font-awesome.min.css') }}">
@endsection
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Bạn đang hãng: <span class="current-name">{{ $brand->name }}</span></strong>
        </header>
        <div class="panel-body">
          <form method="post" class="form-horizontal" role="form" action = "{!! route('admin.brand.postEdit', $brand->id) !!}" enctype="multipart/form-data">
            @include('admin.blocks.error')
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="iptNameAdd" class="col-lg-2 col-sm-2 control-label"><strong>Tên hãng</strong></label>
              <div class="col-lg-10">
                <input class="form-control" name="iptName" value="{!! old('iptName', isset($brand->name) ? $brand->name : null) !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Logo hãng</strong></label>
              <div class="col-lg-10">
                <img src="{{ asset('public/upload/brands/' . $brand->logo) }}">
              </div>
            </div>
            <div class="form-group">
              <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Chọn logo mới</strong></label>
              <div class="col-lg-10">
                <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
              </div>
            </div>
            <div class="form-group">
              <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="iptOrderAdd" value="{!! old('iptOrder', isset($brand->sort_order) ? $brand->sort_order : null) !!}">
              </div>
            </div>
            <div class="form-group">
              <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Mô tả</strong></label>
              <div class="col-lg-10">
                <textarea name="txtDes" rows="5"  class="form-control">{!! old('txtDes', isset($brand->des) ? $brand->sort_order : null) !!}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Từ khóa</strong></label>
              <div class="col-lg-10">
                <input type="text" class="form-control" name="iptKeywords" value="{!! old('iptKeywords', isset($brand->keywords) ? $brand->keywords : null) !!}">
              </div>
            </div>                                                     
            <div class="form-group">
              <div class="col-lg-offset-2 col-lg-10">

                <button type="submit" class="btn btn-success " >Lưu</button>
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
<script src="{{ asset('public/js/jquery.nestable.js') }}"></script>
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