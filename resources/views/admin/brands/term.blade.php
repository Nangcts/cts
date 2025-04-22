<?php use App\Catalog; ?>
@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Bài viết thuộc danh mục: <span style="color: red">{!! $term->name !!}</span></strong>
                </header>
                <div class="panel-body">

                      <div class="adv-table">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      <a style="color: #000" href="{{ route('admin.article.add') }}">Viết bài <i class="icon-plus"></i></a>
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
                                <th>Tiêu đề</th>
                                <th>Ngày đăng</th>
                                <th>Thứ tự</th>
                                <th>Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($article as $item)
                            <tr class="gradeA">
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->title !!}</td>
                                <td>{!! Carbon\Carbon::parse($item->created_at)->format('d/m/Y') !!}</td>
                                <td class="center modal-frame ">
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
                                                      <input id = "{!! $item->id !!}" name ="Article" type="number" step ="1" class="input_order" placeholder="" value = "{!! $item->sort_order !!}" >
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
                                <td class="center ">        

                                  <a href="{{ route('admin.article.edit',$item->id) }}" data-toggle="modal" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>

                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.article.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Bài viết này?')"><i class="icon-trash "></i></a>
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