@extends('front.master')
@section('content')
<!-- Content Article category -->
<section class="warranty-check-panel">
    <div class="warranty-box row">
            <div class="warranty-title">
                <h3>Kiểm tra mã bảo hành</h3>
            </div>
            <div class="warranty-check-form">
                <form method="post" class="form-horizontal" role="form" action = "{{ route('postWarrantyCheck') }}">
                      @include('admin.blocks.error')
                      <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                      
                      <div class="form-group">
                            <div class="col-sm-12"><input pattern=".{17}" class="form-control" name="iptWarrantyCode" value="" placeholder="Nhập số serial trên thẻ bảo hành" title="Mã bảo hành dạng: xxxx-xxxxxx-xxxxx"></div>
                      </div>
                                                 
                      <div class="form-group">
                          <div class="col-lg-offset-2 col-lg-10">
                              <button type="submit" class="btn btn-success">Kiểm tra</button>
                              <button type="reset"  class="btn btn-default">Nhập lại</button>
                          </div>
                      </div>
                </form>

            </div>
        </div>
    @if (!empty($data))
    <div class="result-box-warranty">    
        <div class="check-result bg-info" style="padding: 10px;font-weight: bold;">Mã bảo hành đã kiểm tra là Sản phẩm chính hãng do HD PROTECHVN sản xuất</div>
        <div class="table-responsive">
             <table class="table table-hover table-stripped">
                 <thead>
                     <tr>
                         <th>Mã bảo hành</th>
                         <th>Ngày kích hoạt bảo hành</th>
                         <th>Ngày hết hạn bảo hành</th>
                     </tr>
                 </thead>
                 <tbody>
                     <tr>
                         <td>{{ $data->serial }}</td>
                         <td>{{ date("d/m/Y", strtotime($data->active)) }}</td>
                         <?php 
                            $expired_warranty = strtotime('+12 month',strtotime($data->active)); 
                            $expired_warranty = date ( 'Y-m-j' , $expired_warranty );
                         ?>
                         <td>{{ date("d/m/Y", strtotime($expired_warranty)) }}</td>
                     </tr>
                 </tbody>
             </table>
         </div> 
    </div>
     @elseif (!empty($error))
     <div style="background-color: red; color: #fff;width:100%;float: left; padding: 7px 10px;">{!! $error !!} - Hoặc mã nhập sai, Vui lòng liên hệ 094 880 0004</div>
     </div>
     @endif

</section>
@endsection