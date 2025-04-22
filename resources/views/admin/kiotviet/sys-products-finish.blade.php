<?php use App\Catalog; ?>
@extends('master')
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>các sản phẩm được cập nhật hoặc thêm mới</strong>
        </header>
        <div class="panel-body">
          <div class="btn-group pull-right">
            <a  id="editable-sample_new" class="btn btn-info" href="{{ route('admin.product.list') }}">
              Tới trang sản phẩm <i class="fa fa-link"></i>
            </a>
          </div>
          <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="example">
              @include('admin.blocks.error')
              <thead>
                <tr>
                  <th>ID Kiot</th>
                  <th>Tên danh mục</th>
                  <td>Ngày cập nhật</td>
                </tr>
              </thead>
              <tbody>
                @foreach($arr_products_sys as $item)
                <tr class="gradeA">
                  <td>{!! $item->id !!}</td>
                  <td>{!! $item->fullName !!}</td>
                  <td>{{ isset($item->modifiedDate) ? (\Carbon\Carbon::parse($item->modifiedDate)->format('d/m/y')) : 'Thêm mới' }}</td>
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