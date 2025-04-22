<section id="quick_menu">
    <div class="wrapper container">
        <ul class="items row">
            @foreach (App\Catalog::GetRootCatalogs()->get() as $item)
            <li class="col-md-2 col-sm-4 col-xs-4">
                <a title="{{ $item->name }}" href="{{ route('allRoute', $item->slug) }}">
                    <img alt="{{ $item->name }}" src="{{ asset('upload/filemanager/catalog/'.$item->image) }}" style="border-width:0px;">
                </a>
                <a class="quick-menu-name" title="" href="{{ route('allRoute', $item->slug) }}">{{ $item->name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
</section>