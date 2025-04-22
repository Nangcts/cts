@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        <header class="panel-heading">
          <strong>Thêm mới vai trò người dùng(role)</strong>
        </header>
        <div class="panel-body">
          <form class="form-horizontal" role="form" action="{{ route('admin-manager.postAddRole') }}" method="POST" enctype="multipart/form-data">
            @include('admin.blocks.error')
            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
            <div class="add-post">
              <div class="col-lg-12 col-md-12 col-info-post">
                <div class="form-group">
                  <label for="iptTitle" class="control-label">Tên vai trò</label>
                  <div class="">
                    <input type="text" class="form-control" name="iptTitle" placeholder="" value="{!! old('iptTitle') !!}">
                  </div>
                </div>
                <div class="form-group">
                  <div class="panel panel-info">
                    <div class="panel-heading">
                      <h3 class="panel-title">Thiết lập quyền</h3>
                    </div>
                    <div class="panel-body">
                      <ul class="list-permission-group">
                        @foreach ($permission_group as $item)
                        <li class="col-md-4 col-sm-6 col-xs-12 col-group">
                          <label>{{ $item->title }}</label>
                          <ul class="list-permission">
                            <?php $permissions = $item->permissions; ?>
                            @foreach ($permissions as $permission)
                            <li>
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" value="{{ $permission->id }}" name="permissions[]">
                                  {{ $permission->title }}
                                </label>
                              </div>
                            </li>
                            @endforeach
                          </ul>
                        </li>
                        @endforeach                      
                      </ul>
                    </div>
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
