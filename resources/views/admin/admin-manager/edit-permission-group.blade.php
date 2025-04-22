@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Sửa nhóm quyền</strong>
        </header>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="{{ route('admin-manager.saveEditPermissionGroup', $group->id) }}" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            @csrf
            <div class="add-post">
              <div class="col-lg-12 col-md-12 col-info-post">
                <div class="form-group">
                  <label for="iptGroupTitle" class="control-label"><strong>Tên nhóm</strong></label>
                  <div class="">
                    <input type="text" class="form-control" name="iptGroupTitle" placeholder="" value="{!! old('iptGroupTitle', isset($group->title) ? $group->title : null) !!}">
                  </div>
                </div>
              </div>
            </div>
            <div class="save-post row">
              <div class="col-lg-12 save-post-button">
                <button type="submit" class="btn btn-success "><i class="fa fa-save"></i>  Lưu</button>
                <button type="button"  class="btn btn-default"><a href="{{ URL::previous() }}"><i class="fa fa-step-backward"></i>  Quay lại</a></button>
              </div>
            </div>                  
          </form>
        </div>
      </section>
    </div>
  </div>
  <!-- page end-->
</section>
@endsection
