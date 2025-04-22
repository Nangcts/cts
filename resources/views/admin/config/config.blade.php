@extends('master')
@section('content')
<section class="wrapper">
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      <header class="panel-heading">
        <strong>Cấu hình Website</strong>
      </header>
    </div>
    <div class="panel-body">
      <form method="post" class="form-horizontal"  role="form" action = "{!! URL('admin/config') !!}" enctype="multipart/form-data">

        @include('admin.blocks.error')
        @include('admin.blocks.flash')
        <input type="hidden" name="_token" value="{!! csrf_token() !!}">

        <div class="form-group">
          <label for="iptSiteTitle" class="col-lg-2 col-sm-2 control-label"><strong>Tên Webstie</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptSiteTitle" value="{!! old('iptSiteTitle',isset($config->site_title) ? $config->site_title : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptCompany" class="col-lg-2 col-sm-2 control-label"><strong>Số tài khoản</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptCompany" value="{!! old('iptCompany',isset($config->company_name) ? $config->company_name : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptSlogan" class="col-lg-2 col-sm-2 control-label"><strong>Slogan</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptSlogan" value="{!! old('iptSlogan',isset($config->slogan) ? $config->slogan : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptHotline" class="col-lg-2 col-sm-2 control-label"><strong>Số Hotline 1</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptHotline" value="{!! old('iptHotline',isset($config->hotline) ? $config->hotline : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptSkype" class="col-lg-2 col-sm-2 control-label"><strong>Skype</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptSkype" value="{!! old('iptSkype',isset($config->skype) ? $config->skype : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptAdress" class="col-lg-2 col-sm-2 control-label"><strong>Địa chỉ</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptAdress" value="{!! old('iptAdress',isset($config->adress) ? $config->adress : null) !!}" >
          </div>
        </div>                      
        <div class="form-group">
          <label for="iptPhone" class="col-lg-2 col-sm-2 control-label"><strong>Số Hotline 2</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptPhone" value="{!! old('iptPhone',isset($config->phone) ? $config->phone : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptPhone2" class="col-lg-2 col-sm-2 control-label"><strong>Số di động</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptPhone2" value="{!! old('iptPhone2',isset($config->phone2) ? $config->phone2 : null) !!}" >
          </div>
        </div>   
        <div class="form-group">
          <label for="iptEmail" class="col-lg-2 col-sm-2 control-label"><strong>Email</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptEmail" value="{!! old('iptEmail',isset($config->email) ? $config->email : null) !!}" >
          </div>
        </div>     
        <div class="form-group">
          <label for="iptFace" class="col-lg-2 col-sm-2 control-label"><strong>Fanpage Facebook</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptFace" value="{!! old('iptFace',isset($config->facebook) ? $config->facebook : null) !!}" >
          </div>
        </div>
        <div class="form-group">
          <label for="iptAnalytics" class="col-lg-2 col-sm-2 control-label"><strong>Mã analytics</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptAnalytics" value="{!! old('iptAnalytics',isset($config->analytics) ? $config->analytics : null) !!}" placeholder="Mã dạng: UA-xxxxxx-x">
          </div>
        </div>
        <div class="form-group">
          <label for="iptMasterTool" class="col-lg-2 col-sm-2 control-label"><strong>Mã xác minh Webmaster Tool</strong></label>
          <div class="col-lg-10">
            <input class="form-control" name="iptMasterTool" value="{!! old('iptMasterTool',isset($config->master_tool) ? $config->master_tool : null) !!}" placeholder="dãy mã số xác minh từ google web master tool">
          </div>
        </div>
        <div class="form-group">
          <label for="txtInfo" class="col-lg-2 col-sm-2 control-label"><strong>Thông tin thêm</strong></label>
          <div class="col-lg-10">
            <textarea name="txtInfo" rows="3"  class="form-control">{!! old('txtInfo',isset($config->info) ? $config->info : null) !!}</textarea>
          </div>
        </div>                                                                                         
        <div class="form-group">
          <label for="txtKeywords" class="col-lg-2 col-sm-2 control-label"><strong>Từ khóa SEO</strong></label>
          <div class="col-lg-10">
            <textarea name="txtKeywords" rows="3"  class="form-control">{!! old('txtKeywords',isset($config->site_keywords) ? $config->site_keywords : null) !!}</textarea>
          </div>
        </div>  
        <div class="form-group">
          <label for="txtDes" class="col-lg-2 col-sm-2 control-label"><strong>Mô tả SEO</strong></label>
          <div class="col-lg-10">
            <textarea name="txtDes" rows="5"  class="form-control">{!! old('txtDes',isset($config->site_des) ? $config->site_des : null) !!}</textarea>
          </div>
        </div>   
        <div class="form-group">
          <label for="iptLogo" class="col-lg-2 col-sm-2 control-label"><strong>Logo</strong></label>
          <div class="col-lg-10">
            <img style="width:45px; margin:5px 0;" src="{{ asset('upload/filemanager/logo/'.$config->site_logo) }}" alt="" class="img-thumbnal">
            <br>Chọn ảnh mới <br>
            <input type="file" name="iptLogo" class="form-control" />
          </div>
        </div>                                                                 
        <div class="form-group">
          <div class="col-lg-offset-2 col-lg-10">

            <button type="submit" class="btn btn-success " >Lưu</button>
            <button data-dismiss="form" class="btn btn-danger" type="button">Hủy</button>
          </div>
        </div>
      </form>
    </div>
  </section>
</section>

@endsection('content')                                              