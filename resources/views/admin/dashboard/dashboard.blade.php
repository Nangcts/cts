@extends('master')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.oesmith.co.uk/morris-0.5.1.css">
@endsection
@section('content')
<section class="wrapper">
  <div class="col-lg-12">
    <!-- Page Title & Breadcrumb -->
    <div class="page-header">
      <div class="page-header-title">
        <h4>Trang tổng quan</h4>
      </div>
      <div class="page-header-breadcrumb">
        <div class="breadcrumb-title">
          {!! Breadcrumbs::render('dashboard') !!}
        </div>
      </div>
    </div>
    <!--state overview start-->
    <div class="row state-overview">
      <div class="col-lg-12 " style="margin-bottom: 15px">
        <div class="small-wrap bg-white">
          <div class="btn-group pull-right" >
            <a style="margin-right: 10px" id="editable-sample_new" class="btn btn-info" href="{!! route('sitemap') !!}">
              Update Sitemap <i class="fa fa-sitemap"></i>
            </a>
            <a style="margin-right: 10px" id="editable-sample_new" class="btn btn-info" href="/sitemap.xml">
              Xem sitemap <i class="fa fa-sitemap"></i>
            </a>
            <a style="margin-right: 10px" id="editable-sample_new" class="btn btn-info" href="{!! route('admin.article.add') !!}">
              Viết bài <i class="fa fa-plus"></i>
            </a>
            <a id="editable-sample_new" class="btn btn-info" href="{!! route('admin.product.add') !!}">
              Đăng sản phẩm <i class="fa fa-plus"></i>
            </a>

          </div>
        </div>
      </div>

      <div class="col-lg-4 col-overview col-sm-6">
        <div class="card table-card">
          <div class="">
            <div class="row-table">
              <div class="col-sm-6 card-block-big br">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-user"></i>
                  </div>
                  <div class="col-sm-9 text-center">
                    <h5>{{ $data_analytics['active'] ? $data_analytics['active'] : 0 }}</h5>
                    <span>Khách đang online</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 card-block-big">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-user-circle-o"></i>
                  </div>
                  <div class="col-sm-9 text-center">
                    <h5>{{ $data_analytics['today']['visitors'] ? $data_analytics['today']['visitors'] : 0 }}</h5>
                    <span>Khách trong ngày</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="row-table">
              <div class="col-sm-6 card-block-big br">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-eye"></i>
                  </div>
                  <div class="col-sm-9 text-center">
                    <h5>{{ $data_analytics['today']['pageViews'] ?  $data_analytics['today']['pageViews'] : 0 }}</h5>
                    <span>lượt xem trang hôm nay</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 card-block-big">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-bar-chart"></i>
                  </div>
                  <div class="col-sm-9 text-center">
                    <h5>{{ $data_analytics['month_visitors'] ? $data_analytics['month_visitors'] : 0 }}</h5>
                    <span>Khách trong tháng</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-overview col-sm-6">
        <div class="card table-card">
          <div class="">
            <div class="row-table">
              <div class="col-sm-6 card-block-big br">
                <div class="row">
                  <div class="col-sm-4">
                    <i class="fa fa-shopping-cart"></i>
                  </div>
                  <div class="col-sm-8 text-center">
                    <h5>{{ App\Product::count() }}</h5>
                    <span>Sản phẩm</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 card-block-big">
                <div class="row">
                  <div class="col-sm-4">
                    <i class="fa fa-list"></i>
                  </div>
                  <div class="col-sm-8 text-center">
                    <h5>{{ App\Catalog::count() }}</h5>
                    <span>Loại sản phẩm</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="">
            <div class="row-table">
              <div class="col-sm-6 card-block-big br">
                <div class="row">
                  <div class="col-sm-4">
                    <i class="fa fa-newspaper-o"></i>
                  </div>
                  <div class="col-sm-8 text-center">
                    <h5>{{ App\Article::count() }}</h5>
                    <span>Bài viết</span>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 card-block-big">
                <div class="row">
                  <div class="col-sm-4">
                    <i class="fa fa-list"></i>
                  </div>
                  <div class="col-sm-8 text-center">
                    <h5>{{ App\Cate::count() }}</h5>
                    <span>Danh mục bài viết</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-overview col-sm-6">
        <div class="card table-card widget-primary-card">
          <div class="">
            <div class="row-table">
              <div class="col-sm-3 card-block-big">
                <i class="fa fa-comment" style="color: #fff; font-size: 34px"></i>
              </div>
              <div class="col-sm-9">
                <h4>4000 +</h4>
                <h6>Ratings Received</h6>
              </div>
            </div>
          </div>
        </div>
        <div class="card table-card widget-success-card">
          <div class="">
            <div class="row-table">
              <div class="col-sm-3 card-block-big">
                <i class="fa fa-facebook" style="color: #fff; font-size: 34px"></i>
              </div>
              <div class="col-sm-9">
                <h4>17</h4>
                <h6>Share</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--state overview end-->
    <!-- Analytics Chart -->
    <div class="row">
      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Lượt khách vào website</h3>
          </div>
          <div class="panel-body bg-white">
            <div class="text-center">
              <label class="label label-success">Lượt truy cập</label>
              <div id="area-chart" ></div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Nguồn truy cập (30 ngày gần đây)</h3>
          </div>
          <div class="panel-body  bg-white">
            <div id="organic-chart" ></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="panel panel-info ">
          <div class="panel-heading">
            <h3 class="panel-title">Thiết bị truy cập 30 ngày qua</h3>
          </div>
          <div class="panel-body bg-white">
            <div id="devices-chart" ></div>
            <table style="padding: 7px; text-align: center;width: 100%">
              <tr>
                <td>Máy tính để bàn</td>
                <td>Di động</td>
                <td>Máy tính bảng</td>
              </tr>
              @if(!$data_analytics['devices']->isEmpty())
              <tr>
                <td style="font-weight: bold;">

                  @if(isset($data_analytics['devices'][0]))
                  {{ round(($data_analytics['devices'][0]['count']/$data_analytics['devices']->sum('count'))*100, 2) }} %
                  @else
                  0 %
                  @endif
                </td>
                <td style="font-weight: bold;">
                  @if(isset($data_analytics['devices'][1]))
                  {{ round(($data_analytics['devices'][1]['count']/$data_analytics['devices']->sum('count'))*100, 2) }} %
                  @else
                  0 %
                  @endif
                </td>
                <td style="font-weight: bold;">
                  @if(isset($data_analytics['devices'][2]))
                  {{ round(($data_analytics['devices'][2]['count']/$data_analytics['devices']->sum('count'))*100, 2) }} %
                  @else
                  0 %
                  @endif
                </td>

              </tr>
              @endif
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title">Trang xem nhiều nhất 7 ngày qua</h3>
          </div>
          <div class="panel-body bg-white">
            <table class="table table-condensed table-hover">
              <thead>
                <tr>
                  <th>URL</th>
                  <th>Tên trang</th>
                  <th>Số lần xem</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data_analytics['top_visited_pages'] as $item)
                <tr>
                  <td>{{ $item['url'] }}</td>
                  <td>{{ $item['pageTitle'] }}</td>
                  <td>{{ $item['pageViews'] }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <!-- End Analytics Chart -->
    <div class="row">
      <div class="col-lg-12">
        <section class="panel panel-info">
          <header class="panel-heading">
            <strong>Sản phẩm mới nhất</strong>
          </header>
          <div class="panel-body  bg-white">
            <div class="adv-table">
              <table  class="display table table-bordered table-striped" id="example">
                @include('admin.blocks.error')
                @include('admin.blocks.flash')
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Ngày đăng</th>
                    <th>Danh mục</th>
                    <th>Tác vụ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $products = DB::table('products')->orderBy('created_at','DESC')->take(20)->get() ?>
                  @if (isset($products))
                  @foreach($products as $item)
                  <tr class="gradeA">
                    <td>{!! $item->id !!}</td>
                    <td>{!! $item->name !!}</td>
                    <td class="center">{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    <td class="center">
                      <?php $categories = App\Product::find($item->id)->categories()->get() ?>
                      <ul>
                        @foreach ($categories as $category_item)
                        <li><a href="{{ route('allRoute', $category_item->slug) }}"><i class="fa fa-arrow-right" style="margin-right: 7px; font-size: 10px"></i>{{ $category_item->name }}</a></li>
                        @endforeach
                      </ul>
                    </td>
                    <td class="center">                              
                      <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.product.getEdit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-danger btn-xs" href = "{!! route('admin.product.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa Sản phẩm này?')"><i class="fa fa-trash "></i></a>
                    </td>
                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>

            </div>
          </div>
        </section>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <section class="panel panel-info">
          <header class="panel-heading">
            <strong>Bài viết mới nhất</strong>
          </header>
          <div class="panel-body bg-white">
            <div class="adv-table">
              <table  class="display table table-bordered table-striped" id="dash_article">
                @include('admin.blocks.error')
                @include('admin.blocks.flash')
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Ngày đăng</th>
                    <th>Danh mục</th>
                    <th>Tác vụ</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $articles = DB::table('article')->take(20)->get() ?>
                  @if (isset($articles))
                  @foreach($articles as $item)

                  <tr class="gradeA">
                    <td>{!! $item->id !!}</td>
                    <td>{!! $item->title !!}</td>
                    <td class="center">{{ Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                    <td class="center">
                      {!! App\Article::find($item->id)->cate->name !!}
                    </td>
                    <td class="center">                              
                      <a data-toggle="modal" class="btn btn-primary btn-xs" href = "{!! route('admin.article.edit',$item->id) !!}"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-danger btn-xs" href = "{!! route('admin.article.delete', $item->id) !!}" onclick="return confirmdelete('Bạn có chắc sẽ xóa bài viết này?')"><i class="fa fa-trash "></i></a>
                    </td>
                  </tr>
                  @endforeach
                  @endif


                </tbody>
              </table>

            </div>
          </div>
        </section>
      </div>
    </div>    
  </div>
</section>
@endsection
@section('js')
<script src="{{ URL('js/count.js') }}"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script type="text/javascript">
  Morris.Donut({
    element: 'devices-chart',
    data: [
    @foreach ($data_analytics['devices'] as $item)
    { label: "{{ $item['device'] }}", value: {{ $item['count'] }} },
    @endforeach
    ]
  });

  Morris.Bar({
    element: 'organic-chart',
    behaveLikeLine: true,
    data: [
    @foreach ($data_analytics['organic_search'] as $key => $item)
    { source: '{{ $item['source'] }}', total: {{ $item['count'] }} },
    @if($key > 4)
    @break
    @endif
    @endforeach
    ],
    xkey: 'source',
    ykeys: ['total'],
    labels: 'Số lượt',
    barRatio: 0.4,
    xLabelAngle: 35,
    barColors:['#1abc9c'],
    hideHover: 'auto'
  });

  Morris.Area({
    element: 'area-chart',
    behaveLikeLine: true,
    data: [
    @foreach ($data_analytics['total_page_views'] as $key=>$item)
    { day: '{{  \Carbon\Carbon::parse($item['date'])->format('d/m') }}', visitors: {{ $item['visitors'] }}, pageViews: {{ $item['pageViews'] }} },
    @endforeach
    ],
    xkey: 'day',
    ykeys: ['visitors', 'pageViews'],
    labels: ['Lượt truy cập', 'Lượt xem trang'],
    parseTime: false,
    pointFillColors:['rgb(126, 129, 203)'],
    pointStrokeColors: ['rgb(126, 129, 203)'],
    lineColors:['#2ecc71','#1abc9c'],
    fillOpacity: 0.4
  });
  
  $(document).ready(function() {
    $('#dash_article').dataTable( {
      "columnDefs": [
      { "orderable": false, "targets": 0 }
      ],
      "aaSorting": [[ 1, "desc" ]],
      "iDisplayLength": -1,
      "sPaginationType": "full_numbers",
    })
  });
</script>
@endsection