<?php use App\Catalog; ?>
@extends('master')
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>các danh mục được cập nhật hoặc thêm mới</strong>
        </header>
        <div class="panel-body">
          <div class="btn-group pull-right">
            <a  id="editable-sample_new" class="btn btn-info" href="{{ route('admin.getNested') }}">
              Tới trang danh mục <i class="fa fa-link"></i>
            </a>
          </div>
          <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="example">
              @include('admin.blocks.error')
              <thead>
                <tr>
                  <th>ID Kiot</th>
                  <th>Tên danh mục</th>
                </tr>
              </thead>
              <tbody>
                @foreach($categories as $item)
                <tr class="gradeA">
                  <td>{!! $item->categoryId !!}</td>
                  <td>{!! $item->categoryName !!}</td>
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