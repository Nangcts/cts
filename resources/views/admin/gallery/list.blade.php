<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý Album ảnh</strong>
                </header>
                <div class="panel-body">
                      <div class="btn-group pull-right">
                          <button id="editable-sample_new" class="btn green">
                              <a href="{!! route('admin.gallery.getAdd') !!}">Thêm Mới Album <i class="icon-plus"></i></a>
                          </button>
                      </div>
                      <div class="adv-table">
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên Album</th> 
                                <th>Ngày đăng</th>
                                <th>Danh mục</th>
                                <th>Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $item)
                            <tr class="gradeA">
                                <td>{!! $item->id !!}</td>
                                <td><a href="{{ route('admin.gallery.view',$item->id) }}">{!! $item->g_title !!}</a></td>          
                                <td>
                                <?php 
                                   $date_time = Carbon\Carbon::parse($item->created_at)->format('d/m/Y'); ?>    
                                   {!!  date("d/m/Y", strtotime($item->created_at)) !!}
                                </td>

                                <td class="center">
                                <?php 
                                  $cate_gallery = DB::table('cate_gallery')->where('id',$item->g_cate_id)->first();
                                ?>
                                {!! $cate_gallery->name !!}
                                </td>
                                <td class="center">                              
                                  <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.gallery.getEdit',$item->id) !!}"><i class="icon-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.gallery.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Album này?')"><i class="icon-trash "></i></a>
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