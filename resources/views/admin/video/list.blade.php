<?php use App\Catalog; ?>
@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý video</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <div class="clearfix">
              <div class="">
                <button style="margin-bottom: 10px" class="btn btn-danger delete_all pull-left" data-url="{{ route('admin.article.deleteAll') }}">Xóa chọn <i class="fa fa-trash"></i></button>
                <a href="{!! route('admin.article.add') !!}" id="editable-sample_new" class="btn btn-info pull-right">
                  Thêm Mới <i class="fa fa-plus"></i>
                </a>
              </div>
            </div>
            <table  class="display table table-bordered table-striped" id="example">
              @include('admin.blocks.flash')
              <thead>
                <tr>
                  <th>STT</th>
                  <th>Tiêu đề</th>
                  <th>Ngày đăng</th>
                  <th>Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                <?php $format = 'd/m/y'; ?>
                @foreach($videos as $item)
                <tr class="gradeA">
                  <td>{!! $item->id !!}</td>
                  <td>{{ $item->title }}</td>
                  <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/y') }}</td>      
                  <td class="center">                              
                    <a  class="btn btn-primary btn-xs" href = "{!! route('editVideo',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('deleteVideo', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Video này?')"><i class="fa fa-trash "></i></a>
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