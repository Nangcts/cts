@extends('master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('assets/nested-catalog/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}">
@endsection

@section('content')
<section class="wrapper">
  <!-- page start-->
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
            {!! Breadcrumbs::render('admin-category-update') !!}
            <header class="panel-heading"><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <strong>Quản lý phân loại</strong>
            </header>
        </div>
    <div class="panel-body col-lg-12">
      <div class="adv-table  panel-content-admin">
        <div class="nested-box">
          <div class="col-lg-12 row-button">
            <menu id="nestable-menu">
              <button type="button" class="btn-primary" data-action="expand-all">Mở rộng  <i class=" fa fa-plus"></i></button>
              <button type="button" class="btn-danger" data-action="collapse-all">Thu gọn  <i class="  fa fa-minus"></i></button>
            </menu>
            @include('admin.blocks.error')
            <input type="hidden" id="id">
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12-col-xs-12">   
            <div class="title-block"><i class="fa fa-list"></i>  Phân loại sản phẩm</div>
            <div class="cf nestable-lists">
              <div class="dd" id="nestable">
                <?php
                $query = $categories;
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
                    <div class="dd3-content">  <span id="label_show'.$value['id'].'">'.$value['name'].'</span> 
                    <span class="span-right">
                    <a class="link-button" href = "'. route('admin.product.sort-products',$value['id']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-align-right"></i></a>
                    <a class="link-button" href = "'. route('allRoute',$value['slug']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-link"></i></a>
                    <a class="edit-button" href = "'. route('admin.category.edit',$value['id']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-pencil"></i></a>
                    <a class="del-button" onclick="return confirmdelete('. "'" . 'Bạn có chắc sẽ xóa danh mục này?' . "'" .')" href = "'. route('admin.category.delete',$value['id']) .'" id="'.$value['id'].'"><i class="fa fa-trash"></i></a></span> 
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
            <div class="title-block"><i class="fa fa-list"></i>  Sửa phân loại</div>
            <form method="post" class="form-horizontal " role="form" action = "" enctype="multipart/form-data">
              @include('admin.blocks.error')
              <input type="hidden" name="_token" value="{!! csrf_token() !!}">
              <div class="form-group">
                <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Phân loại cha</strong></label>
                <div class="col-lg-9">
                  <select class="form-control" name="sltParent">
                    <option value="0">Chọn phân loại cha</option>
                    <?php  
                    cate_parent($categories,0," |--",$category->parent_id); 
                    ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Tên danh mục</strong></label>
                <div class="col-lg-9">
                  <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName',isset($category->name) ? $category->name : null) !!}" >
                </div>
              </div>
              <div class="form-group">
                <label for="iptCustomSlug" class="col-lg-3 col-sm-3 control-label">Đường dẫn<br/><span class="help-text" style="font-size: 10px; font-style: italic;">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
                <div class="col-lg-9">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" id="customUrl" name="customUrl" @if($category->custom_url != 0) checked @endif>
                      Nhập đường dẫn (URL)
                    </label>
                  </div>
                  <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{!! old('iptCustomSlug', isset($category->slug) ? $category->slug : null) !!}">
                </div>
              </div>
              <div class="form-group">
                    <label for="iptIcon" class="col-lg-3 col-sm-3 control-label"><strong>Icon</strong></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="text" name="iptIcon" value="{!! old('iptIcon', isset($category->icon) ? $category->icon : null) !!}" >
                    </div>
                  </div>
 
                  <div class="form-group">
                    <label for="iptDes" class="col-lg-12 control-label"><strong>Mô tả</strong></label>
                    <div class="col-lg-12">
                      <textarea name="txtDes" rows="5"  class="form-control ckeditor">{!! old('txtDes', isset($category->long_des) ? $category->long_des : null) !!}</textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-lg-12">
                      <button type="submit" class="btn btn-success " ><i class="fa fa-save"></i>   Lưu</button>
                      <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}">Quay lại</a></button>
                    </div>
                  </div>
                </form>
              </div>

            </div>
          </section>
          <!-- page end-->
        </section>


        @endsection

