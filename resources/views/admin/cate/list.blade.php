<?php use App\cate; ?>
@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý danh mục tin tức</strong>
                </header>
                <div class="panel-body">
                      <div class="adv-table">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn btn-primary">
                                      <a style="color: #000" href="{{ route('admin.cate.add') }}">Thêm danh mục <i class="icon-plus"></i></a>
                                  </button>
                              </div>
                              <div class="btn-group pull-right">
                                  <button class="btn dropdown-toggle" data-toggle="dropdown">Bài viết <i class="icon-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-right">
                                      <?php $cate = DB::table('cate')->get(); 
                                        $route = "cate/";
                                        cate_parent_filter($cate,0,"",$route);
                                      ?>
                                  </ul>
                              </div>
                          </div>
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
                            <?php $stt = 0 ?>
                            @foreach($cate_list as $item)
                            <tr class="gradeA">
                                <td><?php $stt++; echo $stt; ?></td>
                                <td><a href="{{ route('allRoute',$item->slug) }}">{!! $item->name !!}</a></td>
                                <?php $parent = DB::table('cate')->where('id', $item->parent_id)->first() ?>
                                <td>{{ isset($parent) ? $parent->name : 'Danh mục gốc' }}</td>
                                <td class="center modal-frame">
                                  <a id="edit-order-{{ $item->id }}" href="" data-toggle="modal" data-target=".edit-order-{!! $item->id !!}">{!! $item->sort_order !!}</a>                     
                                <!-- Small modal -->
                                  <div class="modal fade edit-order-{!! $item->id !!} custom-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                                    <div class="modal-dialog modal-custom">
                                      <div class="modal-content">
                                          <div class="modal-header modal-header-order">
                                              <h5 class="modal-title modal-title-order" id="myModalLabel">Nhập thứ tự</h5>
                                        </div>
                                        <div class = "modal-body" >
                                        <form class="section-edit-order" action="" method="POST">
                                          <input type="hidden" name = "_token" value = "{!! csrf_token() !!}">
                                            <div class="form-group">
                                                  <div class="col-sm-8">
                                                    <div class="row"></div>
                                                      <input id = "{!! $item->id !!}" name ="Cate" type="number" step ="1" class="input_order" placeholder="" value = "{!! $item->order !!}" >
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <div class="row">
                                                      <button id =  "{!! $item->id !!}" class="btn btn-primary btn-edit-order" type="button">  <i class="glyphicon glyphicon-ok" aria-hidden="true"></i></button>
                                                      <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-hidden="true">×</button>
                                                      </div>
                                                  </div>

                                            </div>
                                            <span class = "glyphicon glyphicon-triangle-bottom"></span>
                                            </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                              <!-- End modal -->
                                </td>
                                <td class="center hidden-phone">                              
                                  <a href="{{ route('admin.cate.getEdit',$item->id) }}" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.cate.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa danh mục này?')"><i class="icon-trash "></i></button>
                                </td>
                            </tr>
                            @endforeach


                            </tbody>
                          </table>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>

@endsection('content')