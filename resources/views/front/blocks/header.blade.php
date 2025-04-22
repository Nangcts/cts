<header>
    <div id="top_header">
        <div class="container">
            <div class="row">
                <div class="top-bar-inner">
                    <ul class="top-bar__list list-unstyled col">
                        <li class="top-bar__item">
                            <a href="" style="color: #666" title=""><i class="fa fa-phone"></i>
                                {{ $config->hotline }}</a>
                        </li>
                        <li class="top-bar__item hidden-xs">
                            <i class="fa fa-envelope"></i>{{ $config->email }}
                        </li>
                    </ul>
                    <div class="pull-right hidden-xs">
                        <ul class="right-top-header">
                            <li>
                                <a class="btn btn-primary btn-sm col-auto" href="{{ route('login') }}"><i
                                        class="fa fa-user"></i> Đăng nhập</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="header-main">
        <div class="container">
            <div class="row row-flex align-items-center">
                <div class="col-lg-2 col-xs-12">
                    @include('front.blocks.menu-button')
                    <a class="site-logo scroll" href="{{ route('index') }}" title="{{ $config->site_title }}"><img
                            class="normal-logo" src="{{ asset('upload/filemanager/logo/'. $config->site_logo) }}"
                            alt="{{ $config->site_title }}"></a>
                </div>
                <div class="col-lg-6 col-search-header col-xs-12">
                    <div class="search-border">
                        <form action="{{ route('search') }}" method="GET">
                            @csrf
                            <input type="text" placeholder="Nhập từ khóa tìm kiếm" name="iptSearch">
                            <button type="submit" class="btn btn-search"><i class="icofont-search"></i></button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 hidden-xs">
                    <div class="pull-right">
                        <ul class="right-top-header">
                            <li>
                                <div class="icon-phone">
                                    <i class="icofont-phone-circle"></i>
                                </div>
                                <div class="hotline-text">
                                    Hotline 24/7
                                    <br>
                                    <b>{{ $config->hotline }}</b>
                                </div>

                            </li>
                            <li>
                                <a class="button-shopping" href="{{ route('cart') }}"><i
                                        class="icofont-shopping-cart"></i> <span
                                        class="cart-count">{{ Cart::count() }}</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="main-menu" class="hidden-xs">
        <div class="container">
            <div class="row">
                <div class="products-menu col-lg-3">
                    <div class="mobile-menu-toggle d-lg-none">
                    <div class="mobile-sidebar">
                            <button class="btn-menu">
                                <i class="fa fa-bars"></i> Danh mục sản phẩm
                            </button>
                        </div>
                        <h3 class="d-none d-lg-block">
                            <i class="fa fa-align-justify"></i><span>Danh mục sản phẩm</span>
                        </h3>
                        <aside class="menu_products">
                            <div class="ruby-wrapper ruby-vertical">
                                <ul class="ruby-menu ruby-vertical">
                                    <li class="home"><a href="{{ route('index') }}" title="Trang chủ"><i
                                                class="fa fa-home mr-7"></i>Trang chủ</a></li>
                                    @foreach (App\Category::where('parent_id',0)->orderBy('sort_order','asc')->get() as
                                    $catalog)
                                    <li class="ruby-menu-mega has-submenu"><a href="{{ route('allRoute', $catalog->slug) }}"
                                            title="{{ $catalog->name }}"><i
                                                class="fa fa-{{ $catalog->icon }} mr-7"></i>{{ $catalog->name }}</a>
                                        <?php $sub_cate_1 =  App\Category::where('parent_id',$catalog->id)->orderBy('sort_order','asc')->get() ?>
                                        @if($sub_cate_1->first())
                                        <div class="ruby-grid ruby-grid-lined">
                                            <div class="ruby-row">
                                                @foreach ($sub_cate_1 as $item_lv1)
                                                <div class="ruby-col-3 hidden-md">
                                                    <h3 class="ruby-list-heading"><a
                                                            href="{{ route('allRoute', $item_lv1->slug) }}"
                                                            title="{{ $item_lv1->name }}">{{ $item_lv1->name }}</a></h3>
                                                    <?php $sub_cate_2 = App\Category::where('parent_id',$item_lv1->id)->orderBy('sort_order','asc')->get() ?>
                                                    @if($sub_cate_2->first())
                                                    <ul>
                                                        @foreach ($sub_cate_2 as $item_lv2)
                                                        <li><a href="{{ route('allRoute', $item_lv2->slug) }}"
                                                                title="{{ $item_lv2->name }}">{{ $item_lv2->name }}</a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </li>
                                    @endforeach

                                </ul>
                            </div>
                        </aside>
                    </div>
                </div>
                <div class="col-lg-9">
                    @include('front.blocks.nav')
                </div>
            </div>
        </div>
    </div>
</header>
<button id="back-to-top" title="Lên đầu trang">
    <i class="fa fa-chevron-up"></i>
</button>
<!-- xử lý navbar -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mainMenu = document.getElementById('main-menu');
    const slider = document.querySelector('section#slider');
    const header = document.querySelector('header');
    const productsMenu = document.querySelector('#main-menu .products-menu');
    const menuProducts = document.querySelector('#main-menu .menu_products');
    const rubyGrids = document.querySelectorAll('.ruby-grid.ruby-grid-lined');
    const isHomePage = window.location.pathname === '/' || window.location.pathname === '{{ route('index', [], false) }}';

    let hideTimeout;

    // Scroll xử lý fixed menu
    window.addEventListener('scroll', function () {
        if (isHomePage) {
            const sliderBottom = slider ? (slider.offsetTop + slider.offsetHeight) : 0;
            if (window.scrollY >= sliderBottom) {
                mainMenu.classList.add('fixed');
            } else {
                mainMenu.classList.remove('fixed');
            }
        } else {
            const menuBottom = mainMenu.offsetTop + mainMenu.offsetHeight;
            if (window.scrollY >= menuBottom) {
                mainMenu.classList.add('fixed');
            } else {
                mainMenu.classList.remove('fixed');
            }
        }
    });

    // Các xử lý hover chỉ dành riêng cho trang chủ
  
        function showMenu() {
            clearTimeout(hideTimeout);
            menuProducts.style.pointerEvents = 'auto';
            menuProducts.style.visibility = 'visible';
            menuProducts.style.opacity = '1';
            menuProducts.style.transition = 'opacity 0.3s ease';
            rubyGrids.forEach(el => el.style.display = 'block');
        }

        function hideMenu() {
            hideTimeout = setTimeout(() => {
                menuProducts.style.opacity = '0';
                menuProducts.style.transition = 'opacity 0.3s ease';
                setTimeout(() => {
                    menuProducts.style.pointerEvents = '';
                    menuProducts.style.visibility = '';
                    rubyGrids.forEach(el => el.style.display = '');
                }, 300);
            }, 150);
        }

        function isMouseOutsideMenuArea(e) {
            return !productsMenu.contains(e.relatedTarget) && !menuProducts.contains(e.relatedTarget);
        }
        
        if (isHomePage) {
    productsMenu.addEventListener('mouseenter', function () {
        if (mainMenu.classList.contains('fixed')) {
            showMenu();
        }
    });
} else {
  
    productsMenu.addEventListener('mouseenter', function () {
        showMenu();
    });
}

        productsMenu.addEventListener('mouseleave', function (e) {
            if (isMouseOutsideMenuArea(e)) hideMenu();
        });

        menuProducts.addEventListener('mouseleave', function (e) {
            if (isMouseOutsideMenuArea(e)) hideMenu();
        });

        menuProducts.addEventListener('mouseenter', function () {
            clearTimeout(hideTimeout);
        });
    
});
</script>

<!-- bai viet moi -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const el = document.getElementById("blog-side");
    const stopAt = document.querySelector("footer");

    if (!el || !stopAt) return;

    const placeholder = document.createElement("div");
    placeholder.style.width = el.offsetWidth + "px";
    placeholder.style.height = el.offsetHeight + "px";
    placeholder.style.display = "none";
    el.parentNode.insertBefore(placeholder, el);

    const initialOffsetTop = el.offsetTop;
    const initialRect = el.getBoundingClientRect();
    const initialLeft = initialRect.left + window.scrollX;
    const initialWidth = initialRect.width;

    function checkPosition() {
        if (window.innerWidth < 1190) {
            el.style.position = "static";
            el.style.left = "";
            el.style.width = "";
            el.style.top = "";
            el.style.bottom = "";
            placeholder.style.display = "none";
            return;
        }

        const stopTop = stopAt.offsetTop;
        const scrollY = window.scrollY;
        const elHeight = el.offsetHeight;

        if (scrollY + elHeight + 20 >= stopTop) {
            el.style.position = "absolute";
            el.style.top = (stopTop - elHeight - 20) + "px";
            el.style.left = initialLeft + "px";
            el.style.width = initialWidth + "px";
            el.style.bottom = "auto";
            placeholder.style.display = "block";
        } else if (scrollY >= initialOffsetTop - 20) {
            el.style.position = "fixed";
            el.style.top = "20px";
            el.style.left = initialLeft + "px";
            el.style.width = initialWidth + "px";
            el.style.bottom = "auto";
            placeholder.style.display = "block";
        } else {
            el.style.position = "static";
            el.style.left = "";
            el.style.width = "";
            el.style.top = "";
            el.style.bottom = "";
            placeholder.style.display = "none";
        }
    }

    window.addEventListener("scroll", checkPosition);
    window.addEventListener("resize", checkPosition);
    checkPosition();
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isTouchDevice = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    const megaMenus = document.querySelectorAll('.ruby-menu-mega.has-submenu');

    if (isTouchDevice) {
        megaMenus.forEach(menuItem => {
            const link = menuItem.querySelector('a');
            const submenu = menuItem.querySelector('.ruby-grid.ruby-grid-lined');

            if (submenu) {
                // Mặc định ẩn
                menuItem.classList.remove('open');

                menuItem.addEventListener('click', function (e) {
                    e.preventDefault(); // chặn điều hướng

                    // Toggle class "open"
                    const isOpen = menuItem.classList.contains('open');
                    megaMenus.forEach(item => item.classList.remove('open')); // đóng tất cả
                    if (!isOpen) menuItem.classList.add('open'); // mở nếu đang đóng
                });
            }
        });

        // Đóng khi click ra ngoài
        document.addEventListener('click', function (e) {
            if (![...megaMenus].some(menu => menu.contains(e.target))) {
                megaMenus.forEach(menuItem => menuItem.classList.remove('open'));
            }
        });
    }
});

</script>
<!-- back to up  -->
<script>
    // Hiển thị nút khi cuộn xuống
    window.addEventListener('scroll', function () {
        const btn = document.getElementById('back-to-top');
        if (window.scrollY > 300) {
            btn.style.display = 'block';
        } else {
            btn.style.display = 'none';
        }
    });

    // Cuộn về đầu trang khi ấn nút
    document.getElementById('back-to-top').addEventListener('click', function () {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
</script>





