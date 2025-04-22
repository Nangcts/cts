@extends('master')
@section('content')
<section class="wrapper">
    <!-- page start-->
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong>Quản lý khối</strong>
                </header>
                <div class="panel-body">
                      <div class="btn-group pull-right">
                          <a id="editable-sample_new" class="btn btn-info" href="{!! route('admin.block.add') !!}">
                              Thêm Mới <i class="fa fa-plus"></i>
                          </a>
                      </div>
                      <div class="adv-table">
                          <table  class="display table table-bordered table-striped" id="example">
                          @include('admin.blocks.error')
                          @include('admin.blocks.flash')
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tiêu đề</th>
                                <th>Ngày đăng</th>
                                <th>Người đăng</th>
                                <th>Tác vụ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $stt = 0 ?>
                            @foreach($block as $item)
                            <?php $stt = ++$stt ?>
                            <tr class="gradeA">
                                <td>{!! $item['id'] !!}</td>
                                <td>{!! $item['title'] !!}</td>
                                <td>{!! \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y') !!}</td>
                                <td>
                                    Admin
                                </td>
                                <td class="center">                              
                                  <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.block.edit',$item['id']) !!}"><i class="fa fa-pencil"></i></a>
                                  <a class="btn btn-danger btn-xs" href = "{!! route('admin.block.delete', $item['id']) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa bải viết này?')"><i class="fa fa-trash "></i></a>
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