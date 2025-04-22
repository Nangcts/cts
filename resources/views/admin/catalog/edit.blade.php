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
        {!! Breadcrumbs::render('admin-catalog-update') !!}

        <header class="panel-heading">
          <strong>Quản lý Danh mục - Menu</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <div class="nested-box row">
              <div class="col-lg-12 row-button">
                <menu id="nestable-menu">
                  <button type="button" class="btn-primary" data-action="expand-all">Mở rộng  <i class=" fa fa-plus"></i></button>
                  <button type="button" class="btn-danger" data-action="collapse-all">Thu gọn  <i class="  fa fa-minus"></i></button>
                </menu>
                @include('admin.blocks.error')
                <input type="hidden" id="id">
              </div>
              <div class="col-lg-6 col-md-6 col-sm-12-col-xs-12">   
                <div class="title-block"><i class="fa fa-list"></i>  Danh mục sản phẩm</div>
                <div class="cf nestable-lists">
                  <div class="dd" id="nestable">
                    <?php
                    $query = $catalogs;
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
                        <a class="link-button" href = "'. route('allRoute',$value['slug']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-link"></i></a>
                        <a class="edit-button" href = "'. route('admin.catalog.edit',$value['id']) .'" id="'.$value['id'].'" label="'.$value['name'].'" link="'.$value['slug'].'" ><i class="fa fa-pencil"></i></a>
                        <a class="del-button" onclick="return confirmdelete('. "'" . 'Bạn có chắc sẽ xóa danh mục này?' . "'" .')" href = "'. route('admin.catalog.delete',$value['id']) .'" id="'.$value['id'].'"><i class="fa fa-trash"></i></a></span> 
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
                    <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Danh mục cha</strong></label>
                    <div class="col-lg-9">
                      <select class="form-control" name="sltParent">
                        <option value="0">Chọn danh mục cha</option>
                        <?php  
                        cate_parent($catalogs,0," |--",$catalog_edit->parent_id); 
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="iptName" class="col-lg-3 col-sm-3 control-label"><strong>Tên danh mục</strong></label>
                    <div class="col-lg-9">
                      <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName',isset($catalog_edit->name) ? $catalog_edit->name : null) !!}" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="iptCustomSlug" class="col-lg-3 col-sm-3 control-label">Đường dẫn<br/><span class="help-text" style="font-size: 10px; font-style: italic;">*Nếu không nhập sẽ lấy đường dẫn tự động</span></label>
                    <div class="col-lg-9">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox" id="customUrl" name="customUrl" @if($catalog_edit->custom_url != 0) checked @endif>
                          Nhập đường dẫn (URL)
                        </label>
                      </div>
                      <div style="float: left; margin-right: 7px; line-height: 32px; color: #777"><?php echo URL('/') ?>/</div><input style="max-width: 350px" type="text" class="form-control" name="iptCustomSlug" placeholder="" value="{!! old('iptCustomSlug', isset($catalog_edit->slug) ? $catalog_edit->slug : null) !!}">
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="" class="col-lg-3 col-sm-3 control-label"><strong>Ảnh đại diện</strong></label>
                    <div class="col-lg-9">
                      <img src="{{ asset('upload/filemanager/catalog/'.$catalog_edit->image) }}" style="max-width: 75px">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="iptImage" class="col-lg-3 col-sm-3 control-label"><strong>Chọn ảnh mới</strong></label>
                    <div class="col-lg-9">
                      <input class="form-control" type="file" name="iptImage" value="{!! old('iptImage') !!}" >
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="" class="control-label col-lg-3 col-md-3"><strong>Hiện trang chủ </strong></label>
                    <div class="col-lg-9 col-md-9">
                      <div class="radio pull-left" style="margin-right: 15px;">
                        <label>
                          <input name="radioShowIndex" id="radioShowIndex" value="1"  type="radio" {{ ($catalog_edit->show_index) == 1 ? "checked" : null }}>
                          có
                        </label>
                      </div>
                      <div class="radio pull-left">
                        <label>
                          <input name="radioShowIndex" id="radioShowIndex" value="0"  type="radio" {{ ($catalog_edit->show_index) == 0 ? "checked" : null }}>
                          Không
                        </label>
                      </div>
                    </div>
                  </div>
                  <!-- <div class="form-group">
                    <label for="" class="col-lg-3 col-sm-3 control-label"><strong>Kiểu danh mục</strong></label>
                    <div class="col-md-9">
                      <div class="radio">
                        <label>
                          <input type="radio" name="rdoType" id="input" value="0" {{ ($catalog_edit->type) == 0 ? "checked" : null }}>
                          Sản phẩm.
                        </label>
                        <label>
                          <input type="radio" name="rdoType" id="input" value="1" {{ ($catalog_edit->type) == 1 ? "checked" : null }}>
                          Tin tức.
                        </label>
                        <label>
                          <input type="radio" name="rdoType" id="input" value="2" {{ ($catalog_edit->type) == 2 ? "checked" : null }}>
                          Custom Menu.
                        </label> 
                      </div>
                    </div>
                  </div> -->
                  <div class="form-group">
                    <label for="iptKeywords" class="col-lg-3 control-label"><strong>Từ khóa SEO</strong></label>
                    <div class="col-lg-9">
                      <textarea name="txtKeywords" rows="3"  class="form-control">{!! old('iptKeywords', isset($catalog_edit->keywords) ? $catalog_edit->keywords : null) !!}</textarea>
                    </div>
                  </div>  
                  <div class="form-group">
                    <label for="iptDes" class="col-lg-3 control-label"><strong>Mô tả SEO</strong></label>
                    <div class="col-lg-9">
                      <textarea name="txtDes" rows="5"  class="form-control">{!! old('txtDes', isset($catalog_edit->des) ? $catalog_edit->des : null) !!}</textarea>
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
        </div>
      </div>
      <!-- page end-->
    </section>


    @endsection

