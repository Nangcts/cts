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
          <strong>Quản lý danh mục Sản phẩm</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <div class="nested-box row">
              <div class="col-lg-12 row-button">
                <menu id="nestable-menu">
                  <button type="button" class="btn-primary" data-action="expand-all">Mở rộng  <i class=" icon-plus"></i></button>
                  <button type="button" class="btn-danger" data-action="collapse-all">Thu gọn  <i class="  icon-minus"></i></button>
                </menu>
                @include('admin.blocks.flash')
                <input type="hidden" id="id">
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12-col-xs-12">   
                <div class="title-block"><i class="icon-list"></i>  Danh mục sản phẩm</div>
                <div id="load"></div>
                <div class="cf nestable-lists">
                  <div class="dd" id="nestable">
                    <?php
                    $query = $catalog;
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
                            <a class="link-button" href = "'. route('allRoute',$value['slug']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="icon-link"></i></a>
                            <a class="edit-button" href = "'. route('admin.catalog.edit',$value['id']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="icon-pencil"></i></a>
                            <a class="del-button" onclick="return confirmdelete('Bạn có chắc sẽ xóa danh mục này?')" href = "'. route('admin.catalog.delete',$value['id']) .'" id="'.$value['id'].'"><i class="icon-trash"></i></a></span> 
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
                  <div class="title-block"><i class="icon-list"></i>  Thêm mới danh mục</div>
                  <form method="post" class="form-horizontal" role="form" action = "{!! URL('admin/catalog/add') !!}">
                    @include('admin.blocks.error')
                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                    <div class="form-group">
                      <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Danh mục cha</strong></label>
                      <div class="col-lg-9">
                        <select class="form-control" name="sltParentAdd">
                          <option value="0">Danh mục cha</option>
                          <?php 
                            cate_parent($catalog,0," |--",0); 
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="iptName" class="col-lg-3 control-label"><strong>Tên danh mục</strong></label>
                      <div class="col-lg-9">
                        <input class="form-control" name="iptNameAdd" value="{!! old('iptName') !!}" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="iptOrder" class="col-lg-3 control-label"><strong>Thứ tự</strong></label>
                      <div class="col-lg-9">
                        <input type="text" class="form-control" name="iptOrderAdd" value="{!! old('iptOrder') !!}">
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="iptKeywords" class="col-lg-3 control-label"><strong>Từ khóa SEO</strong></label>
                      <div class="col-lg-9">
                        <textarea name="txtKeywords" rows="3"  class="form-control">{!! old('iptKeywords') !!}</textarea>
                      </div>
                    </div>  
                    <div class="form-group">
                      <label for="iptDes" class="col-lg-3 control-label"><strong>Mô tả SEO</strong></label>
                      <div class="col-lg-9">
                        <textarea name="txtDes" rows="5"  class="form-control">{!! old('txtDes') !!}</textarea>
                      </div>
                    </div>                                                    

                    <div class="form-group">
                      <div class="col-lg-12">

                        <button type="submit" class="btn btn-success " >Lưu</button>
                        <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Quay lại</a></button>
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </section>
          </div>
        </div>
        <!-- page end-->
      </section>


      @endsection
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
        url: baseURL + '/admin/catalog/nested-post',
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
