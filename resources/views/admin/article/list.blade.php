@extends('master')
@section('content')
<section class="wrapper">
  <section class="panel">
    <div class="col-lg-12 header-page-admin">
      {!! Breadcrumbs::render('admin-article-list') !!}
      <header class="panel-heading">
        <strong>Quản lý Bài viết</strong>
      </header>
    </div>
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
        <table  class="display table table-bordered table-striped" id="article-list">
          @include('admin.blocks.error')
          @include('admin.blocks.flash')
          <thead>
            <tr>
              <th width="50px" class="no-sort"><input type="checkbox" id="master"></th>
              <th>ID</th>
              <th>Tiêu đề</th>
              <th>Danh mục</th>
              <th>Ngày đăng</th>
              <th>Tác vụ</th>
            </tr>
          </thead>
          <tbody>
            @foreach($article_list as $item)
            <tr class="gradeA">
              <td><input type="checkbox" class="sub_chk" data-id="{{$item->id}}"></td>
              <td>{!! $item->id !!}</td>
              <td><a href="{{ route('allRoute', $item->slug) }}">{!! $item->title !!}</a></td>
              <td class="center">
                <?php 
                $cate_name = DB::table('cate')->select('name')->where('id',$item->cate_id)->first();

                ?>
                {!! $cate_name->name !!}
              </td>
              <td>{!! Carbon\Carbon::parse($item->created_at)->format('d/m/Y') !!}</td>
              <td class="center">                              
                <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.article.edit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                <a class="btn btn-danger btn-xs" href = "{!! route('admin.article.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa bải viết này?')"><i class="fa fa-trash "></i></a>
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
$(document).ready( function() {
      $('#article-list').dataTable({
        "pageLength": 20,
        "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0, 3 ] }
        ],
        "aaSorting": [[ 1, "desc" ]],
            "iDisplayLength": -1,
            "sPaginationType": "full_numbers",

        initComplete: function () {
          this.api().columns([3]).every( function () {
            var column = this;
            var select = $('<select><option value="">Tất cả danh mục</option></select>')
            .appendTo( $(column.header()).empty() )
            .on( 'change', function () {
              var val = $.fn.dataTable.util.escapeRegex(
                $(this).val()
                );

              column
              .search( val ? '^'+val+'$' : '', true, false )
              .draw();
            } );

            column.data().unique().sort().each( function ( d, j ) {
              if(column.search() === '^'+d+'$'){
                select.append( '<option value="'+d+'" selected="selected">'+d+'</option>' )
              } else {
                var val = $('<div/>').html(d).text();
                select.append( '<option value="' + val + '">' + val + '</option>' );
              }
            } );
          } );
        }

      });
    });
</script>
@endsection