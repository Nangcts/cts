<?php use App\Catalog; ?>
@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Sản phẩm thuộc danh mục: <span style="color: red">{!! $term->name !!}</span></strong>
                </header>
                <div class="panel-body">
                     <!--  <div class="btn-group pull-right">
                          <button  id="editable-sample_new" class="btn green">
                              <a href="{{ route('admin.catevideo.add') }}">Thêm Mới <i class="icon-plus"></i></a>
                          </button>
                      </div> -->
                      <div class="adv-table">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <button id="editable-sample_new" class="btn green">
                                      <a style="color: #000" href="{{ route('admin.product.add') }}">Thêm sản phẩm <i class="icon-plus"></i></a>
                                  </button>
                              </div>
                              <div class="btn-group pull-right">
                                  <button class="btn dropdown-toggle" data-toggle="dropdown">Sản phẩm <i class="icon-angle-down"></i>
                                  </button>
                                  <ul class="dropdown-menu pull-right">
                                      <?php $catalog = DB::table('catalog')->get(); ?>
                                      <li><a href="{{ route('admin.product.list') }}">Tất cả Sản phẩm</a></li>
                                      @foreach ($catalog as $item)
                                      <li><a href="{{ route('admin.catalog.term', $item->id) }}">{{ $item->name }}</a></li>
                                      @endforeach
   
                                  </ul>
                              </div>
                          </div>
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.error')
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên sản phẩm</th>
                                <th>ảnh</th>
                                <th>Giá bán</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th class="hidden-phone">Thứ tự</th>
                                <th class="hidden-phone">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($term_product as $item)
                            <tr class="gradeA">
                                <td>{!! $item->id !!}</td>
                                <td>{!! $item->name !!}</td>
                                <td class="center">
                                     <img style="width:70px;" src="{{ asset('public/upload/product/'.$item->image) }}" type="">
                                </td>
                                <td>{{ $item->price }}</td>
                                <td>{!! $item->created_at !!}</td>
                                <td>
                                <?php
                                  if ($item->status == 0) {
                                    echo "Sẵn hàng";
                                  } elseif ($item->status == 1) {
                                    echo "Đã cho thuê";
                                  } else {
                                    echo "Hết hàng";
                                  }
                                ?>
                                </td>
                                <td class="center hidden-phone">{!! $item->sort_order !!}</td>
                                <td class="center hidden-phone">        

                                  <a href="{{ route('admin.product.edit',$item->id) }}" data-toggle="modal" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>

                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.product.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa sản phẩm này?')"><i class="icon-trash "></i></a>
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