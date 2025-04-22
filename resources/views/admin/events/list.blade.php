@extends('master')
@section('content')
<section class="wrapper">
  <!-- page start-->
  <div class="row">
    <div class="col-lg-12">
      <section class="panel">
        {!! Breadcrumbs::render('admin-event-list') !!}
        <header class="panel-heading">
          <strong>Quản sự kiện đã làm</strong>
        </header>
        <div class="panel-body">
          <div class="adv-table">
            <table  class="display table table-bordered table-striped" id="article-list">
              @include('admin.blocks.error')
              @include('admin.blocks.flash')
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Tiêu đề</th>
                  <th>Mô tả</th>
                  <th>Ngày đăng</th>
                  <th>Tác vụ</th>
                </tr>
              </thead>
              <tbody>
                @foreach($events as $item)
                <tr class="gradeA">
                  <td>{!! $item->id !!}</td>
                  <td>{!! $item->title !!}</td>
                  <td>{{ $item->intro }}</td>
                  <td>{!! Carbon\Carbon::parse($item->created_at)->format('d/m/Y') !!}</td>
                  <td class="center">                              
                    <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.event.edit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                    <a class="btn btn-danger btn-xs" href = "{!! route('admin.event.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa sự kiện này?')"><i class="fa fa-trash "></i></a>
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
@section('js')
<script type="text/javascript">
  $(document).ready(function() {
    $('#master').on('click', function(e) {
      if($(this).is(':checked',true))  
      {
        $(".sub_chk").prop('checked', true);  
      } else {  
        $(".sub_chk").prop('checked',false);  
      }  
    });
    $('.delete_all').on('click', function(e) {

      var allVals = [];  
      $(".sub_chk:checked").each(function() {  
        allVals.push($(this).attr('data-id'));
      });  

      if(allVals.length <=0)  
      {  
        alert("Vui lòng chọn Bài viết cần xóa!.");  
      }  else {  

        var check = confirm("Bạn có chắc sẽ xóa các Bài viết đã chọn?");  
        if(check == true){  

          var join_selected_values = allVals.join(","); 

          $.ajax({
            url: $(this).data('url'),
            type: 'GET',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: 'ids='+join_selected_values,
            success: function (data) {
              if (data['success']) {
                $(".sub_chk:checked").each(function() {  
                  $(this).parents("tr").remove();
                });
                alert(data['success']);
              } else if (data['error']) {
                alert(data['error']);
              } else {
                alert('Whoops Something went wrong!!');
              }
            },
            error: function (data) {
              alert(data.responseText);
            }
          });

          $.each(allVals, function( index, value ) {
            $('table tr').filter("[data-row-id='" + value + "']").remove();
          });
        }  
      }  
    });
  });

</script>

<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
    $(document).ready( function() {
      $('#article-list').dataTable({
        "pageLength": 20,
        "aaSorting": [[ 1, "desc" ]],
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0, 3 ] }
        ],

      });
    });
  });
</script>
@endsection