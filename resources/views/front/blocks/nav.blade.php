
<?php
$root_catalogs = App\Catalog::GetRootCatalogs()->get();
$root_categories = App\Category::where('parent_id',0)->get();
?>

<!-- START: RUBY DEMO HEADER -->
<div class="ruby-menu-demo-header">
    <!-- ########################### -->
    <!-- START: RUBY HORIZONTAL MENU -->
    <div class="ruby-wrapper">
        <nav class="nav-navbar clearfix navar_menu" id="bs-navbar">
            <ul class="ruby-menu">
                <?php $categories = App\Category::where('parent_id',0)->orderBy('sort_order','asc')->get() ?>
                @foreach ($categories as $category)
                <?php $childs = App\Category::where('parent_id',$category->id)->orderBy('sort_order','asc')->get() ?>
                <li class="root_item visible-xs">
                    <a href="{{ route('allRoute', $category->slug) }}" title="{{ $category->name }}">{{ $category->name }}</a>
                    @if($childs->count())
                    <ul class="sub_cate sub_lv_1">
                        @foreach($childs as $item)
                        <li><a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
                <?php $cates = App\Cate::where('parent_id',0)->where('check_menu', 1)->orderBy('sort_order','asc')->get() ?>
                @foreach ($cates as $cate)
                <?php $childs = App\Cate::where('parent_id',$cate->id)->orderBy('sort_order','asc')->get() ?>
                <li class="root_item">
                    <a href="{{ route('allRoute', $cate->slug) }}" title="{{ $cate->name }}">{{ $cate->name }}</a>
                    @if($childs->count())
                    <ul class="sub_cate sub_lv_1">
                        @foreach($childs as $item)
                        <li><a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a></li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </li>
        </ul>
    </nav>
</div>
<!-- END:   RUBY HORIZONTAL MENU -->
