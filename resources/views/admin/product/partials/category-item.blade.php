@if(isset($category))
<li class="nav-item">
    <a href="{{ route('admin.sort-offer-products', $category->id) }}" 
       class="nav-link {{ request()->is('*/sort-offer-products/'.$category->id) ? 'active' : '' }}">
        {{ $category->name }}
    </a>
    
    @if($category->children && $category->children->isNotEmpty())
        <ul class="nav nav-pills flex-column ml-3">
            @foreach($category->children as $child)
                @include('admin.product.partials.category-item', ['category' => $child])
            @endforeach
        </ul>
    @endif
</li>
@endif