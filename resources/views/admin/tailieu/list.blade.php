<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý Tài liệu</strong>
                </header>
                <div class="panel-body">
                      <div class="btn-group pull-right">
                          <button id="editable-sample_new" class="btn green">
                              <a href="{!! route('admin.tai-lieu.getAdd') !!}">Thêm Mới <i class="icon-plus"></i></a>
                          </button>
                      </div>
                      <div class="adv-table">
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên tài liệu</th> 
                                <th>Ngày đăng</th>
                                <th>Danh mục</th>
                                <th>Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                            <tr class="gradeA">
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->name !!}</td>          
                                <td>
                                <?php 
                                   $date_time = Carbon\Carbon::parse($item->created_at)->format('d/m/Y'); ?>    
                                   {!!  date("d/m/Y", strtotime($item->created_at)) !!}
                                </td>

                                <td class="center">
                                <?php 
                                  $cate_tai_lieu = DB::table('cate_tai_lieu')->where('id',$item->cate_id)->first();
                                ?>
                                {!! $cate_tai_lieu->name !!}
                                </td>
                                <td class="center">                              
                                  <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.tai-lieu.getEdit',$item->id) !!}"><i class="icon-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.tai-lieu.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa tài liệu này?')"><i class="icon-trash "></i></a>
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