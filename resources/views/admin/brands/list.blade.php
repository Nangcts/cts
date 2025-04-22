<?php use App\cate; ?>
@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý danh sách hãng</strong>
                </header>
                <div class="panel-body">
                      <div class="adv-table">
                          <div class="clearfix">
                              <div class="btn-group">
                                  <a id="editable-sample_new" class="btn btn-primary" href="{{ route('admin.brand.add') }}">
                                      Thêm mới hãng <i class="icon-plus"></i>
                                  </a>
                              </div>
                          </div>
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.error')
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tên hãng</th>
                                <th>Logo</th>
                                <th class="hidden-phone">Thứ tự</th>
                                <th class="hidden-phone">Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($brands as $item)
                            <tr class="gradeA">
                                <td>{{ $item->id }}</td>
                                <td><a href="{{ route('allRoute',$item->slug) }}">{!! $item->name !!}</a></td>
                                <td><img style="max-width: 125px;" src="{{ asset('public/upload/brands/' . $item->logo) }}"></td>
                                <td>{{ $item->sort_order }}</td>
                                <td class="center hidden-phone">                              
                                  <a href="{{ route('admin.brand.edit',$item->id) }}" class="btn btn-primary btn-xs"><i class="icon-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.brand.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa danh mục này?')"><i class="icon-trash "></i></button>
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