<?php 
$catalog = DB::table('catalog')->where('parent_id', 0)->orderBy('sort_order','asc')->get();
?>
<div class="wrap-main-2 mobile-off" style="height:60px; background-color:#0685c7;">
    <div class="wrap-main">
        <div id="menu-bot" style="text-align: center; padding-top:8px;">
            <ul class="top-menu">
                <li class="sub-menu-parent">
                    <a href="{{ route('index') }}">Trang chủ</a>
                </li>
                @foreach ($catalog as $item)
                <li class="sub-menu-parent">
                    <a href="{{ route('allRoute', $item->slug) }}" title="{{ $item->name }}">{{ $item->name }}</a>
                </li>
                @endforeach
            </ul>
            <!--end top menu-->
        </div>
    </div>
</div>

<div class="wrap-main-2" style="background-color:#006092;">
    <div class="wrap-main">
        <div id="copyright">
            {{ print_block(4) }}
        </div>
    </div>
</div>