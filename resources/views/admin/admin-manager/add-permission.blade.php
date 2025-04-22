@extends('master')  
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thêm mới quyền trên hệ thống(Permission)</strong>
        </header>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="{{ route('admin-manager.postAddPermission') }}" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="col-lg-6 col-md-6 col-info-post">
              <div class="form-group">
                <label for="iptTitle" class="control-label">Tên quyền</label>
                <div class="">
                  <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle') !!}">
                </div>
              </div>                  
              <div class="form-group">
                <label for="iptName" class="control-label">Mã quyền</label>
                <div class="">
                  <input type="text" class="form-control" name="iptName" placeholder="" value="{!! old('iptName') !!}">
                </div>
              </div>
              <div class="form-group">
                <label for="sltPermissionGroup" class="control-label">Nhóm quyền</label>
                <div class="">
                  <select name="sltPermissionGroup" id="inputSltPermissionGroup" class="form-control" required="required">
                    <option value="">--------Chọn nhóm---------</option>
                    @foreach ($permission_group as $item)
                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="form-group save-post-button">
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
