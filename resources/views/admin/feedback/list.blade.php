<?php use App\cate; ?>
@extends('master')
@section('content')

<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý phản hồi khách hàng</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <div class="clearfix">
              <div class="btn-group">
                <a id="editable-sample_new" class="btn btn-primary" href="{{ route('admin.feedback.add') }}">
                  <i class="fa fa-plus"></i> Thêm mới
                </a>
              </div>
            </div>
            <table  class="display table table-bordered table-striped" id="example">
              @include('admin.blocks.error')
              @include('admin.blocks.flash')
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Họ tên</th>
                  <th>Ảnh</th>
                  <th>Địa chỉ</th>
                  <td>Nội dung</td>
                  <th class="hidden-phone">Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($feedbacks as $item)
                <tr class="gradeA">
                  <td>{{ $item->id }}</td>
                  <td>{!! $item->name !!}</td>
                  <td><img style="width: 60px" src="{{ asset('upload/filemanager/feedback/' . $item->image ) }}"></td>
                  <td>{{ $item->adress }}</td>
                  <td>{{ $item->content }}</td>
                  <td class="center hidden-phone">                              
                    <a href="{{ route('admin.feedback.edit',$item->id) }}" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin.feedback.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa phản hồi này?')"><i class="fa fa-trash "></i></button>
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