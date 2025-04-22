<?php use App\Catalog; ?>
@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý danh mục Gallery ảnh</strong>
                </header>
                <div class="panel-body">
                      <div class="btn-group pull-right">
                          <button  id="editable-sample_new" class="btn green">
                              <a href="{{ route('admin.gallery-cate.getAdd') }}">Thêm Mới <i class="icon-plus"></i></a>
                          </button>
                      </div>
                      <div class="adv-table">
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.error')
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th class="hidden-phone">Thứ tự</th>
                                <th class="hidden-phone">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($list as $item)
                            <tr class="gradeA">
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->name !!}</td>
                                <td>
                                <?php 
                                  if($item->parent_id != 0) {

                                    $parent = DB::table('cate_gallery')->where('id',$item->parent_id)->first();
                                    echo($parent->name);

                                  } 
                                  else {
                                    echo "Đây là danh mục gốc";
                                  }
                                 ?>
                                </td>
                                <td class="center hidden-phone">{!! $item->sort_order !!}</td>
                                <td class="center hidden-phone">                              
                                  <a href="{{ route('admin.gallery-cate.getEdit',$item->id) }}"  class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.gallery-cate.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa danh mục này?')"><i class="icon-trash "></i></button>
                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                          </table>
                      </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>

@endsection('content')