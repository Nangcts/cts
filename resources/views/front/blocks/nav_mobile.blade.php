<nav id="nav-mobile" class="hidden-lg hidden-md">
    <ul>
        <?php  $catalogs = DB::table('cate')->where('parent_id', 0)->orderBy('sort_order','asc')->get(); ?>

        @if (isset($catalogs))

        @foreach ($catalogs as $item)

        <li>

            <a href="{{ route('allRoute', $item->slug) }}">{{ $item->name }}</a>

            <?php

            $sub_level_1 = DB::table('catalog')->where('parent_id', $item->id)->orderBy('sort_order', 'asc')->get()

            ?>

            @if (!empty($sub_level_1))

            <ul>

                @foreach ($sub_level_1 as $sub_item_1)

                <li><a href="{{ route('allRoute', $sub_item_1->slug) }}" title="{{ $sub_item_1->name }}">{{ $sub_item_1->name }}</a>

                    <?php

                    $sub_level_2 = DB::table('catalog')->where('parent_id', $sub_item_1->id)->orderBy('sort_order', 'asc')->get()

                    ?>

                    @if (!empty($sub_level_2))

                    <ul>

                        @foreach ($sub_level_2 as $sub_item_2)

                        <li><a href="{{ route('allRoute', $sub_item_2->slug) }}" title="{{ $sub_item_2->name }}">{{ $sub_item_2->name }}</a></li>

                        @endforeach

                    </ul>

                    @endif

                </li>

                @endforeach

            </ul>

            @endif

        </li>

        @endforeach

        @endif

    </ul>

</nav>