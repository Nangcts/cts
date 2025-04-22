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
          <strong>Bạn đang sửa danh mục: <span class="current-name">{{ $cate_edit->name }}</span></strong>
        </header>
        <div class="panel-body">
          <div class="nested-box row">
            <div class="col-lg-12 row-button">
              <menu id="nestable-menu">
                <button type="button" class="btn-primary" data-action="expand-all">Mở rộng  <i class=" fa fa-plus"></i></button>
                <button type="button" class="btn-danger" data-action="collapse-all">Thu gọn  <i class="  fa fa-minus"></i></button>
              </menu>
              @include('admin.blocks.flash')
              <input type="hidden" id="id">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12-col-xs-12">   
              <div class="title-block"><i class="fa fa-list"></i>  Danh mục sản phẩm</div>
              <div id="load"></div>
              <div class="cf nestable-lists">
                <div class="dd" id="nestable">
                  <?php
                  $query = $cate_list;
                  $ref   = [];
                  $items = [];
                  foreach ($query as $data) {
                    $thisRef = &$ref[$data->id];
                    $thisRef['parent_id'] = $data->parent_id;
                    $thisRef['name'] = $data->name;
                    $thisRef['slug'] = $data->slug;
                    $thisRef['id'] = $data->id;

                    if($data->parent_id == 0) {
                      $items[$data->id] = &$thisRef;
                    } else {
                      $ref[$data->parent_id]['child'][$data->id] = &$thisRef;
                    }
                  }
                  function get_menu($items,$class = 'dd-list') {

                    $html = "<ol class=\"".$class."\" id=\"menu-id\">";

                    foreach($items as $key=>$value) {
                      $html.= '<li class="dd-item dd3-item" data-id="'.$value['id'].'" >
                      <div class="dd-handle dd3-handle"></div>
                      <div class="dd3-content"><span id="label_show'.$value['id'].'">'.$value['name'].'</span> 
                      <span class="span-right">
                      <a class="link-button" href = "'. route('allRoute',$value['slug']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-link"></i></a>
                      <a class="edit-button" href = "'. route('admin.cate.getEdit',$value['id']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-pencil"></i></a>
                      <a class="del-button"  onclick="return confirmdelete('. "'" . 'Bạn có chắc sẽ xóa danh mục này?' . "'" .')" href = "'. route('admin.cate.delete',$value['id']) .'" id="'.$value['id'].'"><i class="fa fa-trash"></i></a></span> 
                      </div>';
                      if(array_key_exists('child',$value)) {
                        $html .= get_menu($value['child'],'child');
                      }
                      $html .= "</li>";
                    }
                    $html .= "</ol>";

                    return $html;

                  }

                  print get_menu($items);

                  ?>
                </div>
              </div>
              <p></p>
              <input type="hidden" id="nestable-output">
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12-col-xs-12">
              <div class="title-block"><i class="fa fa-list"></i>  Sửa danh mục</div>
              <form method="post" class="form-horizontal " role="form" action = "" enctype="multipart/form-data">
                @include('admin.blocks.error')
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <div class="form-group">
                  <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Danh mục cha</strong></label>
                  <div class="col-lg-10">
                    <select class="form-control" name="sltParent">
                      <option value="0">Chọn danh mục cha</option>
                      <?php 
                      cate_parent($cate_list,0," |--",$cate_edit['parent_id']); 
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="iptName" class="col-lg-2 col-sm-2 control-label"><strong>Tên danh mục</strong></label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName',isset($cate_edit['name']) ? $cate_edit['name']:null) !!}" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="iptCustomSlug" class="col-lg-2 col-sm-2 control-label">Đường dẫn<br/><span class="help-text" style="font-size: 10px; font-style: italic;">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>

                  <div class="col-lg-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" id="customUrl" name="customUrl" @if($cate_edit['custom_slug'] == 1) checked @endif>
                        Nhập đường dẫn (URL)
                      </label>
                    </div>
                    <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{!! old('iptCustomSlug', isset($cate_edit['slug']) ? $cate_edit['slug'] : null) !!}">
                  </div>
                </div>

                <div class="form-group">
                  <label for="iptImage" class="col-lg-2 col-sm-2 control-label"><strong>Chọn ảnh mới</strong></label>
                  <div class="col-lg-10">
                    <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="iptChecked" class="col-lg-2 col-sm-2 control-label"><strong>Menu top </strong></label>
                  <div class="col-lg-10">
                    <div class="radio pull-left" style="margin-right: 15px;">
                      <label>
                        <input {{ ($cate_edit->check_menu) == 1 ? "checked" : null }}  name="optionsRadiosMenu" id="optionsRadios1" value="1"  type="radio">
                        có
                      </label>
                    </div>
                    <div class="radio pull-left">
                      <label>
                        <input {{ ($cate_edit->check_menu) == 0 ? "checked" : null }} name="optionsRadiosMenu" id="optionsRadiosMenu1" value="0"  type="radio">
                        Không
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="iptOrder" class="col-lg-2 col-sm-2 control-label"><strong>Thứ tự</strong></label>
                  <div class="col-lg-10">
                    <input type="text" class="form-control" name="iptOrder" placeholder="Thứ tự" value="{!! old('iptOrder',isset($cate_edit['sort_order']) ? $cate_edit['sort_order']:null) !!}">
                  </div>
                </div>    
                <div class="form-group">
                  <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Mô tả</strong></label>
                  <div class="col-lg-10">
                    <textarea name="txtDes" rows="5"  class="form-control">{{ old('txtDes',isset($cate_edit['des']) ? $cate_edit['des']:null) }}</textarea>
                  </div>
                </div>                                                
                <div class="form-group">
                  <div class=" col-lg-12">
                    <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Quay lại</a></button>
                    <button type="submit" class="btn btn-primary "><i class="fa fa-save"></i>   Lưu</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
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