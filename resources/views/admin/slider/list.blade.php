@extends('master')
@section('content')
<section class="wrapper">

  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      {!! Breadcrumbs::render('admin-slider') !!}
      <header class="panel-heading">
        <strong>Quản lý Slider</strong>
      </header>
    </div>
    <div class="panel-body">

      <div class="adv-table">
        <div class="btn-group pull-right">
          <a id="editable-sample_new" class="btn btn-info" href="{!! route('admin.slider.add') !!}">
            Thêm Mới <i class="fa fa-plus"></i>
          </a>
        </div>
        <table  class="display table table-bordered table-striped" id="example">
          @include('admin.blocks.error')
          @include('admin.blocks.flash')
          <thead>
            <tr>
              <th>ID</th>
              <th>Ảnh</th>
              <th>Thứ tự</th>
              <th>Ngày đăng</th>
              <th>Tác vụ</th>
            </tr>
          </thead>
          <tbody>

            @foreach($slider as $item)

            <tr>
              <td>{!! $item->id !!}</td>
              <td class="center"><img style = "width:200px;" src="{!! asset('upload/filemanager/slider/'.$item->slide) !!}" alt=""></td>
              <td>
                {!! $item->sort_order !!}
              </td>
              <td>{!! Carbon\Carbon::parse($item->created_at)->format('d/m/Y') !!}</td>
              <td class="center">                              
                <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.slider.edit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                <a class="btn btn-danger btn-xs" href = "{!! route('admin.slider.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa ảnh này?')"><i class="fa fa-trash "></i></a>
              </td>
            </tr>
            @endforeach


          </tbody>
        </table>

      </div>
    </div>
  </section>

</section>

@endsection('content')