<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý sản phẩm Sale</strong>
        </header>
        <div class="panel-body">
          <div class="btn-group pull-right">
            <button id="editable-sample_new" class="btn btn-primary">
              <a href="{!! route('admin.product.add') !!}">Thêm Mới <i class="icon-plus"></i></a>
            </button>
          </div>
          <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="example">
              @include('admin.blocks.flash')
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Ảnh</th>
                  <th>Tên sản phẩm</th>
                  <th>Ngày đăng</th>
                  <th>Thứ tự</th>
                  <th>Đơn giá</th>
                  <th>Tình trạng sản phẩm</th>
                  <th>Kho</th>
                  <th>Danh mục</th>
                  <th>Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($sales as $item)
                <tr class="gradeA">
                  <td>{!! $item->id !!}</td>
                  <td class="center"><img style = "width:45px; height: 45px;" src="{!! asset('public/upload/product/'. $item->image) !!}" alt=""></td>
                  <td><a href="{{ route('allRoute', $item->slug) }}">{!! $item->name !!}</a></td>
                  <?php 
                  $date_time = Carbon\Carbon::parse($item->created_at)->format('d/m/Y');
                  ?>                  
                  <td>{!!  date("d/m/Y", strtotime($item->created_at)) !!}</td>
                  <td class="modal-frame">
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
                                  <input id = "{!! $item->id !!}" name ="Product" type="number" step ="1" class="input_order" placeholder="" value = "{!! $item->sort_order !!}" >
                                </div>
                              </div>
                              <div class="col-sm-4">
                                <div class="row">
                                  <button id =  "{!! $item->id !!}" class="btn btn-primary btn-edit-order" type="button">  <i class="glyphicon glyphicon-ok" aria-hidden="true"></i></button>
                                  <button type="button" class="close btn btn-danger" data-dismiss="modal" aria-hidden="true">×</button>
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
                  <td class="center">{!! number_format($item->price,0,",",".") !!} đ</td>
                  <td>
                    {{ $item->status }}
                  </td>
                  <td>{{ $item->store_status }}</td>
                  <td class="center">
                    <?php 
                    $catalog = App\Product::find($item->id)->catalog;
                    ?>
                    <a href="{{ route('allRoute', $catalog->slug) }}">{!! $catalog->name !!}</a>
                  </td>
                  <td class="center">                              
                    <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.product.getEdit',$item->id) !!}"><i class="icon-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin.product.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Sản phẩm này?')"><i class="icon-trash "></i></a>
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
</section>
@endsection('content')