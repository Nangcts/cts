<aside class="left-sidebar col-sm-3 col-xs-12 hidden-xs">
    <aside id="woocommerce_product_categories-20" class="widget widget_product_categories">
        <h3 class="widget-title"><span>Danh mục sản phẩm</span>
        </h3>
        <ul class="product-categories">
            @foreach (App\Catalog::GetRootCatalogs()->get() as $item)
            <li class="cat-item cat-item-325"><a href="{{ route('allRoute', $item->slug) }}">{{ $item->name }}</a></li>
            @endforeach
        </ul>
    </aside>
</aside>