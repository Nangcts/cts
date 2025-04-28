@if($offer_products->count())
<ul class="reorder_ul reorder-photos-list">
    @foreach($offer_products as $item)
    <li id="{{ $item->id }}" class="ui-sortable-handle col-lg-3 col-md-3 col-sm-3 col-xs-4"
        style="float: left; width: 100%">
        <div class="move-icon" style="float: left; margin-right: 15px;">
            <i class="fa fa-arrows" aria-hidden="true"></i>
        </div>
        <div class="inner" style="float: left; margin-right: 25px; min-width: 350px">
            {{ $item->name }}
        </div>
        <div class="more-link">
            <a style="padding: 5px 12px; border: 1px solid #ccc;" title="Gỡ sản phẩm" class="btn btn-xs"
                href="{{ route('removeOfferProduct', $item->id) }}"
                onclick="return confirm('Bạn có chắc sẽ loại sản phẩm này?')">
                <i class="fa fa-trash" style="color: red;"></i>
            </a>
        </div>
    </li>
    @endforeach
</ul>
@else
<p>Không có sản phẩm nào trong danh mục này.</p>
@endif
