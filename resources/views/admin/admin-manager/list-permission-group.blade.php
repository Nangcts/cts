@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Quản lý nhóm quyền</strong>
        </header>
        <div class="panel-body">
          <div class="btn-group pull-right">
            <a  href="{!! route('admin-manager.addPermissionGroup') !!}" id="" class="btn btn-primary">
              Thêm Mới <i class="fa fa-plus"></i>
            </a>
          </div>
          <div class="adv-table">
            <table  class="display table table-bordered table-striped table-responsive" id="example">
              @include('admin.blocks.error')
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tên nhóm</th>
                  <th>Thao tác</th>
                </tr>
              </thead>
              <tbody>
                @foreach($list_group as $item)
                <tr class="gradeA" id="tr_{{$item->id}}">
                  <td>{!! $item->id !!}</td>
                  <td>{{ $item->title }}</td>               
                  <td class="center">                              
                    <a class="btn btn-primary btn-xs" href = "{!! route('admin-manager.editPermissionGroup',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin-manager.deletePermissionGroup', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa nhóm quyền này?')"><i class="fa fa-trash "></i></a>
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
@endsection
