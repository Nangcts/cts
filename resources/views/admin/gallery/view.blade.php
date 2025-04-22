@extends('master')
@section('content')

<section class="wrapper">
    <!-- page start-->
    <?php  
      $gallery = DB::table('gallery')->where('id',$id)->first();
      $gallery_img = DB::table('gallery_images')->where('gallery_id',$id)->get();
    ?>
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    <strong class="pull-left">Bạn đang xem Album: <span class="current-name">{{ $gallery->g_title }}</span></strong>
                    <div class="pull-right toolbar-gallery">
                    <a type="button" class="btn btn-danger" href="{{ route('admin.gallery.getEdit',$gallery->id) }}">Sửa</a>
                    <a type="button" class="btn btn-success" href="{{ URL::previous() }}">Quay lại</a>

                    </div>
                </header>
                <div class="panel-body">
                  <div class="row">
                  <form action="" method="POST" role="form" name = "view_album">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @if (isset($gallery) && isset($gallery_img))
                        @foreach ($gallery_img as $item)
                        <div class="col-lg-3 col-xs-4 col-sm-3 box-img-gallery " id="box-{{$item->id}}">
                            <a href="#" class="delete-img delete-img-{{ $item->id }}" id = "{{ $item->id }}"><i class="icon-remove-sign"></i></a>
                            <img style="max-width: 100%" src="{{ asset('public/upload/gallery/'.$item->img_name) }}" alt="">
                        </div>
                        @endforeach
                        @endif
                  </form>
                  </div>
                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>

@endsection('content')