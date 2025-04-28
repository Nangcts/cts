<?php
use Spatie\Analytics\Period;
Route::get('remove-duplicate','ProductController@removeDuplicate');
Route::get('refresh_captcha', 'FrontController@refreshCaptcha')->name('refresh_captcha');
Route::get('decode-intro','ProductController@decodeIntro');
Route::get('analytics', ['as' => 'analytics', 'uses'=>'FrontController@getAnalytics']);
Route::get('get-data','ProductController@getData');
Route::get('get-post','ArticleController@getData');
Auth::routes();
Route::get('/markAsRead',function(){
	auth()->user()->unreadNotifications->markAsRead();
});
Route::get('sitemap', ['as' => 'sitemap', 'uses' => 'DashboardController@updateSiteMap']);

Route::get('/brands', function() {
	return view('front.pages.brands');
});
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', ['as' => 'index', 'uses'  => 'FrontController@getIndex']);
Route::get('/getArticle', ['uses'  => 'ArticleController@getArticle']);
Route::get('thu-vien-video-obh','FrontController@showAllVideo')->name('showAllVideo');
Route::get('video/{id}','FrontController@showVideo')->name('showVideo');
Route::post('bmi','FrontController@checkBMI')->name('checkBMI');

Route::group(['prefix'=>'admin','middleware' => 'auth'], function(){
	Route::get('dashboard',['as' => 'dashboard','uses' => 'DashboardController@getDashboard']);
	Route::get('config',['as' => 'getConfig','uses' => 'ConfigController@getConfig']);
	Route::post('config',['as' => 'postConfig','uses' => 'ConfigController@postConfig']);

	Route::group(['prefix' => 'transaction'], function() {
		Route::get('all-transaction', ['as' => 'transaction.getAllTransaction', 'uses' => 'TransactionController@getAllTransaction']);
		Route::get('view-transaction/{id}', ['as' => 'transaction.viewTransaction', 'uses' => 'TransactionController@viewTransaction']);
		Route::get('change-status/{id}', ['as' => 'transaction.changeStatus', 'uses' => 'TransactionController@changeStatus']);
		Route::post('change-status/{id}', ['as' => 'transaction.postChangeStatus', 'uses' => 'TransactionController@postChangeStatus']);
	});


	Route::group(['prefix' => 'admin-manager'], function() {
		// Users
		Route::get('add-user', ['as' => 'admin-manager.getAddUser', 'uses' => 'AdminController@getAddUser']);
		Route::get('list-user', ['as' => 'admin-manager.getListUser', 'uses' => 'AdminController@getListUser']);
		Route::get('edit-user/{id}', ['as' => 'admin-manager.getEditUser', 'uses' => 'AdminController@getEditUser']);
		Route::post('edit-user/{id}', ['as' => 'admin-manager.postEditUser', 'uses' => 'AdminController@postEditUser']);
		Route::get('delete-user/{id}', ['as' => 'admin-manager.deleteUser', 'uses' => 'AdminController@deleteUser']);
		// Role
		Route::get('add-role', ['as' => 'admin-manager.getAddRole', 'uses' => 'AdminController@getAddRole']);
		Route::post('add-role', ['as' => 'admin-manager.postAddRole', 'uses' => 'AdminController@postAddRole']);
		Route::get('edit-role/{id}', ['as' => 'admin-manager.getEditRole', 'uses' => 'AdminController@getEditRole']);
		Route::post('edit-role/{id}', ['as' => 'admin-manager.postEditRole', 'uses' => 'AdminController@postEditRole']);
		Route::get('delete-role/{id}', ['as' => 'admin-manager.deleteRole', 'uses' => 'AdminController@deleteRole']);
		Route::get('list-roles', ['as' => 'admin-manager.listRoles', 'uses' => 'AdminController@listRoles']);

		// Permission
		Route::get('add-permission', ['as' => 'admin-manager.getAddPermission', 'uses' => 'AdminController@getAddPermission']);
		Route::post('add-permission', ['as' => 'admin-manager.postAddPermission', 'uses' => 'AdminController@postAddPermission']);
		Route::get('edit-permission/{id}', ['as' => 'admin-manager.getEditPermission', 'uses' => 'AdminController@getEditPermission']);
		Route::post('edit-permission/{id}', ['as' => 'admin-manager.postEditPermission', 'uses' => 'AdminController@postEditPermission']);
		Route::get('delete-permission/{id}', ['as' => 'admin-manager.deletePermission', 'uses' => 'AdminController@deletePermission']);
		Route::get('list-permissions', ['as' => 'admin-manager.getListPermissions', 'uses' => 'AdminController@getListPermissions']);
		Route::get('add-permission-group', ['as' => 'admin-manager.addPermissionGroup', 'uses' => 'AdminController@addPermissionGroup']);
		Route::post('add-permission-group', ['as' => 'admin-manager.savePermissionGroup', 'uses' => 'AdminController@savePermissionGroup']);
		Route::get('list-permission-group', ['as' => 'admin-manager.listPermissionGroup', 'uses' => 'AdminController@listPermissionGroup']);
		Route::get('edit-permission-group/{id}', ['as' => 'admin-manager.editPermissionGroup', 'uses' => 'AdminController@editPermissionGroup']);
		Route::post('edit-permission-group/{id}', ['as' => 'admin-manager.saveEditPermissionGroup', 'uses' => 'AdminController@saveEditPermissionGroup']);
		Route::get('delete-permission-group/{id}', ['as' => 'admin-manager.deletePermissionGroup', 'uses' => 'AdminController@deletePermissionGroup']);
		// Cuscomer Account
		Route::get('list-customer-account', ['as' => 'admin-manager.listCustomerAccount', 'uses' => 'AdminController@listCustomerAccount']);
		Route::get('lock-customer-account/{id}', ['as' => 'admin-manager.lockCustomerAccount', 'uses' => 'AdminController@lockCustomerAccount']);
		Route::get('un-lock-customer-account/{id}', ['as' => 'admin-manager.unLockCustomerAccount', 'uses' => 'AdminController@unLockCustomerAccount']);
		Route::get('delete-customer-account/{id}', ['as' => 'admin-manager.deleteCustomerAccount', 'uses' => 'AdminController@deleteCustomerAccount']);
		Route::get('list-customer-transaction/{id}', ['as' => 'admin-manager.listCustomerTransaction', 'uses' => 'AdminController@listCustomerTransaction']);
		Route::get('list-all-upload', ['as' => 'admin-manager.listAllUpload', 'uses' => 'AdminController@listAllUpload']);
		Route::get('confirm-don-thuoc', ['as' => 'admin-manager.confirmDonthuoc', 'uses' => 'AdminController@confirmDonthuoc']);
	});

	Route::group(['prefix' => 'catalog'], function() {
		Route::get('nested-get',['as' => 'admin.getNested', 'uses' => 'CatalogController@getNested']);
		Route::post('nested-post',['as' => 'admin.postNested', 'uses' => 'CatalogController@postNested']);
		Route::post('nested-delete/{id}',['as' => 'admin.deleteNested', 'uses' => 'CatalogController@deleteNested']);
		Route::get('add', ['as' => 'admin.catalog.add', 'uses' => 'CatalogController@getAddCatalog']);
		Route::post('add', ['as' => 'admin.catalog.post', 'uses' => 'CatalogController@postAddCatalog']);
		Route::get('edit/{id}', ['as' => 'admin.catalog.edit', 'uses' => 'CatalogController@getEditCatalog']);
		Route::post('edit/{id}', ['as' => 'admin.catalog.edit', 'uses' => 'CatalogController@postEditCatalog']);
		Route::get('delete/{id}', ['as' => 'admin.catalog.delete', 'uses' => 'CatalogController@getDeleteCatalog']);
		Route::get('term/{id}', ['as' => 'admin.catalog.term', 'uses' => 'CatalogController@getTerm']);
	});
	Route::group(['prefix' => 'category'], function() {
		Route::get('nested-get',['as' => 'admin.category.getNested', 'uses' => 'CategoryController@getNested']);
		Route::post('nested-post',['as' => 'admin.category.postNested', 'uses' => 'CategoryController@postNested']);
		Route::post('nested-delete/{id}',['as' => 'admin.category.deleteNested', 'uses' => 'CategoryController@deleteNested']);
		Route::post('add', ['as' => 'admin.category.post', 'uses' => 'CategoryController@postAddCategory']);
		Route::get('edit/{id}', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@getEditcategory']);
		Route::post('edit/{id}', ['as' => 'admin.category.edit', 'uses' => 'CategoryController@postEditcategory']);
		Route::get('delete/{id}', ['as' => 'admin.category.delete', 'uses' => 'CategoryController@getDeleteCategory']);

	});
	Route::group(['prefix' => 'feedback'], function() {
		Route::get('add', ['as' => 'admin.feedback.add', 'uses' => 'FeedBackController@getAddFeedback']);
		Route::post('add', ['as' => 'admin.feedback.post', 'uses' => 'FeedBackController@postAddFeedBack']);
		Route::get('list', ['as' => 'admin.feedback.list', 'uses' => 'FeedBackController@getListFeedBack']);
		Route::get('edit/{id}', ['as' => 'admin.feedback.edit', 'uses' => 'FeedBackController@getEditFeedBack']);
		Route::post('edit/{id}', ['as' => 'admin.feedback.postEdit', 'uses' => 'FeedBackController@postEditFeedBack']);
		Route::get('delete/{id}', ['as' => 'admin.feedback.delete', 'uses' => 'FeedBackController@getDeleteFeedBack']);
	});
	Route::group(['prefix' => 'brand'], function() {
		Route::get('add', ['as' => 'admin.brand.add', 'uses' => 'BrandsController@getAdd']);
		Route::post('add', ['as' => 'admin.brand.post', 'uses' => 'BrandsController@postAdd']);
		Route::get('list', ['as' => 'admin.brand.list', 'uses' => 'BrandsController@getList']);
		Route::get('edit/{id}', ['as' => 'admin.brand.edit', 'uses' => 'BrandsController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.brand.postEdit', 'uses' => 'BrandsController@postEdit']);
		Route::get('delete/{id}', ['as' => 'admin.brand.delete', 'uses' => 'BrandsController@getDelete']);
		Route::get('term/{id}', ['as' => 'admin.brand.term', 'uses' => 'BrandsController@getTerm']);
	});
	Route::group(['prefix' => 'product'], function() {
		Route::get('clone/{id}', 'ProductController@getCloneProduct')->name('getCloneProduct');
		Route::get('sort-products/{id}', ['as' => 'admin.product.sort-products','uses' => 'ProductController@sortProductsCatalog']);
		Route::post('clone', 'ProductController@storeCloneProduct')->name('storeCloneProduct');
		Route::post('dropzone-uploadImg/{temp_id}', ['as' => 'admin.product.DropzoneUploadImg','uses' => 'ProductController@dropZoneUploadImg']);
		Route::post('delete-dropzone-img', ['as' => 'admin.product.deleteDropzoneImg','uses' => 'ProductController@deleteDropzoneImg']);
		Route::get('add', ['as' => 'admin.product.add','uses' => 'ProductController@getAddProduct']);
		Route::post('add', ['as' => 'admin.product.post','uses' => 'ProductController@postAddProduct']);
		Route::get('list',['as' => 'admin.product.list', 'uses' => 'ProductController@getList']);
		Route::get('search','ProductController@searchProduct')->name('searchProduct');
		Route::get('delete/{id}', ['as' => 'admin.product.delete', 'uses' => 'ProductController@getDeleteProduct']);
		Route::get('edit/{id}', ['as' => 'admin.product.getEdit', 'uses' => 'ProductController@getEditProduct']);
		Route::post('edit/{id}', ['as' => 'admin.product.postEdit', 'uses' => 'ProductController@postEditProduct']);
		Route::get('delete-img', ['as' => 'admin.product.deleteImg', 'uses' => 'ProductController@deleteImg']);
		Route::get('sales', ['as' => 'admin.product.getSales', 'uses' => 'ProductController@getSales']);
		Route::get('deleteAllSelected', ['as' => 'admin.product.deleteAll', 'uses' => 'ProductController@deleteAll']);
		Route::post('filter-product', ['as' => 'admin.product.filter', 'uses' => 'ProductController@filterProduct']);
		Route::post('reorder', ['as' => 'admin.product.reOrder', 'uses' => 'ProductController@reOrderImages']);
		// Hot Products
		Route::get('hot-products', 'ProductController@getHotProducts')->name('sortHotProducts');
		Route::post('reorder-hot-products', 'ProductController@reOrderProducts')->name('reOrderProducts');
		Route::get('remove-hot-product/{id}', 'ProductController@removeHot')->name('removeHotProduct');
		Route::post('reorder-catalog-products', ['as' => 'admin.product.reOrderCatalogProducts', 'uses' => 'ProductController@reOrderCatalogProducts']);
		
		// Offer Products
		Route::get('offer-products', 'ProductController@getOfferProducts')->name('getOfferProducts');
		Route::post('reorder-offer-products', 'ProductController@reOrderOfferProducts')->name('reOrderOfferProducts');
		Route::get('remove-offer-product/{id}', 'ProductController@removeOfferProduct')->name('removeOfferProduct');
		Route::get('/admin/product/sort-offer-products', 'ProductController@showSortOfferProducts')->name('sortOfferProducts');
		Route::post('/admin/product/reorder-offer-products', 'ProductController@reOrderOfferProducts')->name('reOrderOfferProducts');



	});
	Route::group(['prefix'=>'menu'], function() {
		Route::get('add',['as'=>'admin.menu.add','uses'=>'MenuController@getMenu']);
		Route::get('show/{id}',['as'=>'admin.menu.show','uses'=>'MenuController@showMenu']);
		Route::post('add',['as'=>'admin.menu.postMenu','uses'=>'MenuController@postMenu']);
		Route::get('list',['as'=>'admin.menu.list','uses'=>'MenuController@getList']);
		Route::get('edit/{id}',['as'=>'admin.menu.getEdit','uses'=>'MenuController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.menu.postEdit','uses'=>'MenuController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.menu.getDelete','uses'=>'MenuController@getDelete']);
	});	
	Route::group(['prefix'=>'cate'], function() {
		Route::get('/nested-get',['as' => 'admin.cate.getNested', 'uses' => 'CateController@getNested']);
		Route::post('/nested-post',['as' => 'admin.cate.postNested', 'uses' => 'CateController@postNested']);
		Route::post('/nested-delete/{id}',['as' => 'admin.deleteNested', 'uses' => 'CateController@deleteNested']);
		Route::get('add',['as'=>'admin.cate.add','uses'=>'CateController@getAdd']);
		Route::post('add',['as'=>'admin.cate.add','uses'=>'CateController@postAdd']);
		Route::get('list',['as'=>'admin.cate.list','uses'=>'CateController@getList']);
		Route::get('edit/{id}',['as'=>'admin.cate.getEdit','uses'=>'CateController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.cate.postEdit','uses'=>'CateController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.cate.delete','uses'=>'CateController@getDelete']);
		Route::get('term/{id}', ['as' => 'admin.cate.term', 'uses' => 'CateController@getTerm']);
	});	

	Route::group(['prefix' => 'article'], function() {
		Route::get('add', ['as' => 'admin.article.add','uses' => 'ArticleController@getAddArticle']);
		Route::post('add', ['as' => 'admin.article.add','uses' => 'ArticleController@postAddArticle']);
		Route::get('list',['as' => 'admin.article.list', 'uses' => 'ArticleController@getListArticle']);
		Route::get('delete/{id}', ['as' => 'admin.article.delete', 'uses' => 'ArticleController@getDeleteArticle']);
		Route::get('edit/{id}', ['as' => 'admin.article.edit', 'uses' => 'ArticleController@getEditArticle']);
		Route::post('edit/{id}', ['as' => 'admin.article.edit', 'uses' => 'ArticleController@postEditArticle']);
		Route::get('deleteAllSelected', ['as' => 'admin.article.deleteAll', 'uses' => 'ArticleController@deleteAll']);
		
	});

	Route::group(['prefix' => 'event'], function() {
		Route::get('add', ['as' => 'admin.event.add','uses' => 'EventController@getAdd']);
		Route::post('add', ['as' => 'admin.event.add','uses' => 'EventController@postAdd']);
		Route::get('list',['as' => 'admin.event.list', 'uses' => 'EventController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.event.delete', 'uses' => 'EventController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.event.edit', 'uses' => 'EventController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.event.edit', 'uses' => 'EventController@postEdit']);
		Route::get('deleteAllSelected', ['as' => 'admin.event.deleteAll', 'uses' => 'EventController@deleteAll']);
		
	});

	Route::group(['prefix' => 'block'], function() {
		Route::get('add', ['as' => 'admin.block.add','uses' => 'BlockController@getAdd']);
		Route::post('add', ['as' => 'admin.block.add','uses' => 'BlockController@postAdd']);
		Route::get('list',['as' => 'admin.block.list', 'uses' => 'BlockController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.block.delete', 'uses' => 'BlockController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.block.edit', 'uses' => 'BlockController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.block.edit', 'uses' => 'BlockController@postEdit']);
	});
	Route::group(['prefix'=>'member'], function() {
		Route::get('list',['as' => 'admin.member.list','uses' => 'MemberController@getList']);
		Route::get('edit',['as'=>'admin.member.edit','uses' => 'MemberController@getEdit']);
		Route::post('edit',['as'=>'admin.member.postEdit','uses'=>'MemberController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.member.delete','uses'=>'MemberController@getDelete']);
	});

	Route::group(['prefix'=>'video'], function() {
		Route::get('create','VideoController@createVideo')->name('createVideo');
		Route::post('store','VideoController@storeVideo')->name('storeVideo');
		Route::get('list','VideoController@listVideo')->name('listVideo');
		Route::get('edit/{id}','VideoController@editVideo')->name('editVideo');
		Route::post('update/{id}','VideoController@updateVideo')->name('updateVideo');
		Route::get('delete','VideoController@deleteVideo')->name('deleteVideo');
	});	
	Route::group(['prefix' => 'cate-tai-lieu'], function() {
		Route::get('add', ['as' => 'admin.cate-tai-lieu.getAdd', 'uses' => 'CateTailieuController@getAdd']);
		Route::post('add', ['as' => 'admin.cate-tai-lieu.postAdd', 'uses' => 'CateTailieuController@postAdd']);
		Route::get('list', ['as' => 'admin.cate-tai-lieu.list', 'uses' => 'CateTailieuController@getList']);
		Route::get('edit/{id}', ['as' => 'admin.cate-tai-lieu.getEdit', 'uses' => 'CateTailieuController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.cate-tai-lieu.postEdit', 'uses' => 'CateTailieuController@postEdit']);
		Route::get('delete/{id}', ['as' => 'admin.cate-tai-lieu.delete', 'uses' => 'CateTailieuController@getDelete']);
		Route::get('term/{id}', ['as' => 'admin.cate-tai-lieu.term', 'uses' => 'CateTailieuController@getTerm']);
	});
	Route::group(['prefix'=>'tai-lieu'], function() {
		Route::get('list',['as' => 'admin.tai-lieu.list','uses' => 'TailieuController@getList']);
		Route::get('add',['as' => 'admin.tai-lieu.getAdd','uses' => 'TailieuController@getAdd']);
		Route::post('add',['as' => 'admin.tai-lieu.postAdd','uses' => 'TailieuController@postAdd']);
		Route::get('edit/{id}',['as'=>'admin.tai-lieu.getEdit','uses' => 'TailieuController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.tai-lieu.postEdit','uses'=>'TailieuController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.tai-lieu.delete','uses'=>'TailieuController@getDelete']);
		Route::get('customer',['as'=>'admin.tai-lieu.customer','uses'=>'TailieuController@getCustomer']);
		
	});
	// Gallery
	Route::group(['prefix'=>'gallery-cate'], function() {
		Route::get('add',['as'=>'admin.gallery-cate.getAdd','uses'=>'CateGalleryController@getAdd']);
		Route::post('add',['as'=>'admin.gallery-cate.postAdd','uses'=>'CateGalleryController@postAdd']);
		Route::get('list',['as'=>'admin.gallery-cate.list','uses'=>'CateGalleryController@getList']);
		Route::get('edit/{id}',['as'=>'admin.gallery-cate.getEdit','uses'=>'CateGalleryController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.gallery-cate.postEdit','uses'=>'CateGalleryController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.gallery-cate.delete','uses'=>'CateGalleryController@getDelete']);

	});	

	Route::group(['prefix'=>'gallery'], function() {
		Route::get('list',['as' => 'admin.gallery.list','uses' => 'GalleryController@getList']);
		Route::get('view/{id}',['as' => 'admin.gallery.view','uses' => 'GalleryController@getView']);
		Route::get('add',['as' => 'admin.gallery.getAdd','uses' => 'GalleryController@getAdd']);
		Route::post('add',['as' => 'admin.gallery.postAdd','uses' => 'GalleryController@postAdd']);
		Route::get('edit/{id}',['as'=>'admin.gallery.getEdit','uses' => 'GalleryController@getEdit']);
		Route::post('edit/{id}',['as'=>'admin.gallery.postEdit','uses'=>'GalleryController@postEdit']);
		Route::get('delete/{id}',['as'=>'admin.gallery.delete','uses'=>'GalleryController@getDelete']);
		Route::get('customer',['as'=>'admin.gallery.customer','uses'=>'GalleryController@getCustomer']);
		
	});
	Route::group(['prefix' => 'slider'], function() {
		Route::get('add', ['as' => 'admin.slider.add','uses' => 'SliderController@getAdd']);
		Route::post('add', ['as' => 'admin.slider.add','uses' => 'SliderController@postAdd']);
		Route::get('list',['as' => 'admin.slider.list', 'uses' => 'SliderController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.slider.delete', 'uses' => 'SliderController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.slider.edit', 'uses' => 'SliderController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.slider.postEdit', 'uses' => 'SliderController@postEdit']);
	});
	Route::group(['prefix' => 'danh-muc-tour'], function() {
		Route::get('add', ['as' => 'admin.danhmuctour.getAdd','uses' => 'DanhmucTourController@getAdd']);
		Route::post('add', ['as' => 'admin.danhmuctour.postAdd','uses' => 'DanhmucTourController@postAdd']);
		Route::get('list',['as' => 'admin.danhmuctour.getList', 'uses' => 'DanhmucTourController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.danhmuctour.delete', 'uses' => 'DanhmucTourController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.danhmuctour.getEdit', 'uses' => 'DanhmucTourController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.danhmuctour.postEdit', 'uses' => 'DanhmucTourController@postEdit']);
		Route::get('term/{id}', ['as' => 'admin.danhmuctour.term', 'uses' => 'DanhmucTourController@getTerm']);
	});
	Route::group(['prefix' => 'tour'], function() {
		Route::get('add', ['as' => 'admin.tour.getAdd','uses' => 'TourController@getAdd']);
		Route::post('add', ['as' => 'admin.tour.postAdd','uses' => 'TourController@postAdd']);
		Route::get('list',['as' => 'admin.tour.getList', 'uses' => 'TourController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.tour.delete', 'uses' => 'TourController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.tour.getEdit', 'uses' => 'TourController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.tour.postEdit', 'uses' => 'TourController@postEdit']);
	});

	Route::group(['prefix' => 'warranty'], function() {
		Route::get('add', ['as' => 'admin.warranty.getAdd','uses' => 'WarrantyController@getAdd']);
		Route::post('add', ['as' => 'admin.warranty.postAdd','uses' => 'WarrantyController@postAdd']);
		Route::get('addactive', ['as' => 'admin.warranty.getAddActive','uses' => 'WarrantyController@getAddActive']);
		Route::post('addactive', ['as' => 'admin.warranty.postAddActive','uses' => 'WarrantyController@postAddActive']);
		Route::get('list',['as' => 'admin.warranty.getList', 'uses' => 'WarrantyController@getList']);
		Route::get('delete/{id}', ['as' => 'admin.warranty.delete', 'uses' => 'WarrantyController@getDelete']);
		Route::get('edit/{id}', ['as' => 'admin.warranty.getEdit', 'uses' => 'WarrantyController@getEdit']);
		Route::post('edit/{id}', ['as' => 'admin.warranty.postEdit', 'uses' => 'WarrantyController@postEdit']);
	});
	// Admin Edit
	Route::get('admin-edit',['as'=>'admin.adminEdit','uses'=>'AdminController@editAdmin']);
	Route::post('admin-edit',['as'=>'postEditAdmin','uses'=>'AdminController@postEditAdmin']);
	Route::group(['prefix'=>'edit'], function() {
		Route::post('edit-order/{id}',['as'=>'editorder','uses'=>'FrontController@postOrder']);
	});
});
// Route customer
Route::group(['prefix' => 'customer'], function() {
	// Authentication Routes...
	$this->get('login', 'CustomerAuth\LoginController@showLoginForm')->name('customer.login')->middleware('guest');
	$this->post('login', 'CustomerAuth\LoginController@login');
	$this->post('logout', 'CustomerAuth\LoginController@logout')->name('customer.logout');
	$this->get('/edit/{id}', 'CustomerAuth\CustomerController@showCustomerEditForm')->name('customer.showCustomerEditForm')->middleware('customer');

	$this->post('/edit/{id}', 'CustomerAuth\CustomerController@postCustomerEdit')->name('customer.postCustomerEdit')->middleware('customer');

    // Registration Routes...
	$this->get('register', 'CustomerAuth\RegisterController@showRegistrationForm')->name('customer.register');
	$this->post('register', 'CustomerAuth\RegisterController@register');

    // Password Reset Routes...
	$this->get('password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm')->name('customer.password.request');
	$this->post('password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
	$this->get('password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm')->name('customer.password.reset');
	$this->post('password/reset', 'CustomerAuth\ResetPasswordController@reset');
	$this->get('dashboard', 'CustomerAuth\CustomerController@showDashboard')->name('customer.showDashboard')->middleware('customer');
	$this->get('/edit-profile', 'CustomerAuth\CustomerController@showEditProfile')->name('customer.showEditProfile')->middleware('customer');
	$this->post('/edit-profile/{id}', 'CustomerAuth\CustomerController@postEditProfile')->name('customer.postEditProfile')->middleware('customer');
	$this->get('/manager-orders', 'CustomerAuth\CustomerController@showAllOrder')->name('customer.showAllOrder')->middleware('customer');
	$this->get('/detail-order/{id}', 'CustomerAuth\CustomerController@showDetailOrder')->name('customer.showDetailOrder')->middleware('customer');
	$this->get('/uploaded', 'CustomerAuth\CustomerController@showUploadedFile')->name('customer.showUploadedFile')->middleware('customer');
});
Route::get('search',['as' => 'search', 'uses' => 'FrontController@search']);
Route::view('/customer/home', 'customer-home')->middleware('customer');
Route::get('cart', ['as'=>'cart', 'uses' => 'FrontController@getCart']);
Route::get('san-pham-noi-bat','FrontController@showHotProducts')->name('showHotProducts');
Route::get('san-pham-gioi-thieu','FrontController@showOfferProducts')->name('showOfferProducts');
Route::get('san-pham-moi','FrontController@showLastestProducts')->name('showLastestProducts');
Route::get('trang-tin','FrontController@showAllPosts')->name('showAllPosts');
// FrontEnd ROUTE
Route::get('/{slug}', ['as' => 'allRoute', 'uses' => 'FrontController@getAllLink']);

// Contact
Route::get('lien-he',['as' => 'contact','uses' => 'FrontController@getContact']);
Route::post('lien-he',['as' => 'postContact','uses' => 'FrontController@postContact']);
// Giỏ hàng
Route::get('back', ['as' => 'back','uses' => 'FrontController@back']);
Route::get('buy/{id}', ['as'=>'buy', 'uses' => 'FrontController@getBuy']);
Route::post('buy/{id}', ['as'=>'postBuy', 'uses' => 'FrontController@postBuy']);

Route::get('delete/cart',['as'=>'deletecart','uses' => 'FrontController@getDeleteCart']);
Route::get('update/{rowId}/{qty}', ['as' => 'updateCart','uses' => 'FrontController@updateCart']);
Route::get('remove/{rowId}', ['as' => 'removeCart','uses' => 'FrontController@removeCart']);
Route::post('checkout', ['as' => 'checkout', 'uses' => 'FrontController@checkout']);
// Tìm kiếm
Route::post('email-submit', ['as' => 'email.submit', 'uses' => 'FrontController@emailSubmit']);
Route::post('uploadImg', ['as' => 'uploadImage','uses' => 'ProductController@postImages']); 
Route::post('deleteImg', ['as' => 'deleteImage','uses' => 'ProductController@deleteImages']); 
Route::get('filter', ['as' => 'getFilter','uses' => 'FilterController@postFilter']); 
Route::get('setimage',['as' => 'setimage','uses' => 'FrontController@setimage']); 

Route::get('san-pham/{id}',['as' => 'showProduct','uses' => 'FrontController@showProduct']);
Route::get('danh-muc/{id}',['as' => 'showProductCategory','uses' => 'FrontController@showProductCategory']); 
Route::get('/test-permission/{id}', ['as' => 'test.permission', 'uses' => 'FrontController@show']);

// Tìm kiếm tên thuốc
Route::post('search-name', ['as' => 'searchName','uses' => 'FrontController@searchName']);
Route::get('search-benh', ['as' => 'searchBenh','uses' => 'FrontController@getSearchBenh']);
Route::post('search-benh', ['as' => 'searchBenh','uses' => 'FrontController@searchBenh']);
Route::get('tai-don-thuoc', ['as' => 'upload-DonThuoc','uses' => 'FrontController@uploadDonThuoc']);
Route::post('tai-don-thuoc', ['as' => 'postDonThuoc','uses' => 'FrontController@postDonThuoc']);
Route::post('letter-email', ['as' => 'letterEmail','uses' => 'FrontController@postDonThuoc']);

