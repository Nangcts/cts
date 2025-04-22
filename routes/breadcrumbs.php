<?php
// Dashbord
Breadcrumbs::register('dashboard', function($breadcrumbs)
{
    $breadcrumbs->parent('home', route('index'));
    $breadcrumbs->push('Trang dashboard', route('dashboard'));
});
// admin product
Breadcrumbs::register('admin-product-list', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard', route('dashboard'));
    $breadcrumbs->push('Trang sản phẩm', route('admin.product.list'));
});
// admin hot product
Breadcrumbs::register('admin-product-hot', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-product-list', route('admin.product.list'));
    $breadcrumbs->push('Trang sản phẩm nổi bật');
});
// admin offer product
Breadcrumbs::register('admin-product-offer', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-product-list', route('admin.product.list'));
    $breadcrumbs->push('Trang sản phẩm giới thiệu');
});
// admin product create
Breadcrumbs::register('admin-product-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-product-list', route('dashboard'));
    $breadcrumbs->push('Thêm mới sản phẩm');
});
// admin product Edit
Breadcrumbs::register('admin-product-edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-product-list', route('dashboard'));
    $breadcrumbs->push('Sửa sản phẩm');
});
// admin product clone
Breadcrumbs::register('admin-product-clone', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-product-list', route('dashboard'));
    $breadcrumbs->push('Nhân bản sản phẩm');
});
// admin Article list
Breadcrumbs::register('admin-article-list', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Bài viết', route('admin.article.list'));
});
// admin article create
Breadcrumbs::register('admin-article-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-article-list');
    $breadcrumbs->push('Thêm mới bài viết');
});
// admin article Edit
Breadcrumbs::register('admin-article-edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-article-list');
    $breadcrumbs->push('Sửa bài viết');
});
// admin event list
Breadcrumbs::register('admin-event-list', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Sự kiện', route('admin.event.list'));
});
// admin List Video
Breadcrumbs::register('admin-video-list', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Danh sách video', route('listVideo'));
});
// admin Create Video
Breadcrumbs::register('admin-video-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-video-list');
    $breadcrumbs->push('Thêm mới Video');
});
// admin video Edit
Breadcrumbs::register('admin-video-edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-video-list');
    $breadcrumbs->push('Sửa Video');
});

// admin event create
Breadcrumbs::register('admin-event-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-event-list');
    $breadcrumbs->push('Thêm mới sự kiện');
});
// admin event Edit
Breadcrumbs::register('admin-event-edit', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-event-list');
    $breadcrumbs->push('Sửa Sự kiện');
});

// admin sldier
Breadcrumbs::register('admin-slider', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('quản lý slider', route('admin.slider.list'));
});
// admin slider create
Breadcrumbs::register('admin-slider-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-slider');
    $breadcrumbs->push('Thêm mới slide');
});
// admin slider edit
Breadcrumbs::register('admin-slider-update', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-slider');
    $breadcrumbs->push('Cập nhật slide');
});
// admin catalog
Breadcrumbs::register('admin-catalog', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Danh mục sản phẩm', route('admin.getNested'));
});
Breadcrumbs::register('admin-category', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Phân loại sản phẩm', route('admin.getNested'));
});
// admin slider create
Breadcrumbs::register('admin-catalog-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-catalog');
    $breadcrumbs->push('Thêm mới danh mục sản phẩm');
});
Breadcrumbs::register('admin-category-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-category');
    $breadcrumbs->push('Thêm mới phân loại');
});
// admin slider edit
Breadcrumbs::register('admin-catalog-update', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-catalog');
    $breadcrumbs->push('Cập nhật danh mục sản phẩm');
});
Breadcrumbs::register('admin-category-update', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-category');
    $breadcrumbs->push('Cập nhật phân loại sản phẩm');
});
// admin transaction
Breadcrumbs::register('admin-transaction', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Quản lý giao dịch', route('transaction.getAllTransaction'));
});
// admin transaction-view
Breadcrumbs::register('admin-transaction-view', function($breadcrumbs, $transaction)
{
    $breadcrumbs->parent('admin-transaction');
    $breadcrumbs->push('Chi tiết giao dịch', route('transaction.viewTransaction', $transaction->id));
});
// admin customer Account
Breadcrumbs::register('admin-customer-account', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Quản lý tài khoản khách hàng', route('admin-manager.listCustomerAccount'));
});
// admin customer Account transaction
Breadcrumbs::register('admin-customer-transaction', function($breadcrumbs, $customer)
{
    $breadcrumbs->parent('admin-customer-account');
    $breadcrumbs->push('Chi tiết giao dịch', route('admin-manager.listCustomerTransaction', $customer->id));
});
// admin FeebBack list
Breadcrumbs::register('admin-feedback', function($breadcrumbs)
{
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('Quản lý phản hồi khách hàng', route('admin.feedback.list'));
});
// admin FeebBack create
Breadcrumbs::register('admin-feedback-create', function($breadcrumbs)
{
    $breadcrumbs->parent('admin-feedback');
    $breadcrumbs->push('Thêm mới phản hồi khách');
});

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push('Trang chủ', route('index'));
});
// Home > Upload
Breadcrumbs::register('upload', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tải đơn thuốc', route('upload-DonThuoc'));

});

// Home > contact

Breadcrumbs::register('contact', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Liên hệ', route('contact'));
});

// Home > [Cate]

Breadcrumbs::register('cate', function($breadcrumbs, $cate)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($cate->name,route('allRoute',$cate->slug));
});
// Chi tiết bài viết

Breadcrumbs::register('detail', function($breadcrumbs,$cate, $article)
{
    $breadcrumbs->parent('cate',$cate);
    $breadcrumbs->push($article->title);
});
// Home > [Catalog]

Breadcrumbs::register('catalog', function($breadcrumbs, $catalog)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($catalog->name,route('allRoute',$catalog->slug));
});
// Chi tiết Sản phẩm

Breadcrumbs::register('product', function($breadcrumbs, $product)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($product->name);
});
// Chi tiết Sản phẩm

Breadcrumbs::register('search', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tìm kiếm');
});
// Tag Product

Breadcrumbs::register('tag', function($breadcrumbs, $tag)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push($tag->tag_name);
});

// Trang sản phẩm nổi bật
Breadcrumbs::register('hot-product', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sản phẩm nổi bật');
});

// Trang sản phẩm Giới thiệu
Breadcrumbs::register('offer-product', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sản phẩm giới thiệu');
});

// Trang sản phẩm mới
Breadcrumbs::register('lastest-product', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Sản phẩm mới đăng');
});
// Trang tin
Breadcrumbs::register('allPost', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Trang tin tức');
});