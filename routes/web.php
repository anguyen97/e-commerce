<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('admin')->group(function(){
	// Authentication Routes...
	Route::get('', 'AdminAuth\LoginController@showLoginForm');
	Route::get('login', 'AdminAuth\LoginController@showLoginForm')->name('admin.login');
	Route::post('login', 'AdminAuth\LoginController@login')->name('admin.login.process');
	Route::post('logout', 'AdminAuth\LoginController@logout')->name('admin.logout');

    // Registration Routes...
	Route::get('register', 'AdminAuth\RegisterController@showRegistrationForm')->name('admin.register');
	Route::post('register', 'AdminAuth\RegisterController@register')->name('admin.signin');

    // Password Reset Routes...
	Route::get('password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
	Route::post('password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm')->name('admin.password.reset');
	Route::post('password/reset', 'AdminAuth\ResetPasswordController@reset');

	Route::middleware('admin.auth')->group(function(){
		

		Route::get('', 'Admin\HomeController@getIndex');

		Route::get('home', 'Admin\HomeController@getIndex')->name('admin.home');

		Route::group(['prefix' => 'brands'], function() {

			Route::get('/','Admin\BrandController@getIndex')->name('admin.brand');

			Route::get('/listBrand','Admin\BrandController@anyData')->name('admin.brand.dataTable');

			Route::post('/store', 'Admin\BrandController@store')->name('admin.brand.store');

			Route::get('show/{id}', 'Admin\BrandController@show');

			Route::get('edit/{id}', 'Admin\BrandController@edit');

			Route::put('update/{id}', 'Admin\BrandController@update');

			Route::delete('delete/{id}', 'Admin\BrandController@delete');

		});

		Route::group(['prefix' => 'categories'], function() {

			Route::get('/','Admin\CategoryController@getIndex')->name('admin.category');

			Route::get('/listCategory','Admin\CategoryController@anyData')->name('admin.category.dataTable');

			Route::post('/store', 'Admin\CategoryController@store')->name('admin.category.store');

			Route::get('show/{id}', 'Admin\CategoryController@show');

			Route::get('edit/{id}', 'Admin\CategoryController@edit');

			Route::put('update/{id}', 'Admin\CategoryController@update');

			Route::delete('delete/{id}', 'Admin\CategoryController@delete');

		});

		Route::group(['prefix' => 'admins'], function() {

			Route::get('/','Admin\AdminController@getIndex')->name('admin.admin');

			Route::get('/listAdmin','Admin\AdminController@anyData')->name('admin.admin.dataTable');

			Route::post('/store', 'Admin\AdminController@store')->name('admin.admin.store');

			Route::get('show/{id}', 'Admin\AdminController@show');

			// Route::get('edit/{id}', 'Admin\AdminController@edit');

			// Route::put('update/{id}', 'Admin\AdminController@update');

			Route::delete('delete/{id}', 'Admin\AdminController@delete');

		});

		Route::group(['prefix' => 'users'], function() {

			Route::get('/','Admin\UserController@getIndex')->name('admin.user');

			Route::get('/listUser','Admin\UserController@anyData')->name('admin.user.dataTable');

			Route::post('/store', 'Admin\UserController@store')->name('admin.user.store');

			Route::delete('delete/{id}', 'Admin\UserController@delete');

		});

		Route::group(['prefix' => 'products'], function() {

			Route::get('/','Admin\ProductController@getIndex')->name('admin.product');

			Route::get('/listProduct','Admin\ProductController@anyData')->name('admin.product.dataTable');
			
			Route::post('/store', 'Admin\ProductController@store')->name('admin.product.store');

			Route::get('/show/{id}', 'Admin\ProductController@show');

			Route::get('/details/{id}', 'Admin\ProductController@getProductDetails');

			Route::delete('delete/{id}', 'Admin\ProductController@delete');

		});

		Route::group(['prefix' => 'sizes'], function() {

			Route::get('/','Admin\SizeController@getIndex')->name('admin.size');

			Route::get('/listSize','Admin\SizeController@anyData')->name('admin.size.dataTable');

			Route::post('/store', 'Admin\SizeController@store')->name('admin.size.store');

			Route::get('edit/{id}', 'Admin\SizeController@edit');

			Route::put('update/{id}', 'Admin\SizeController@update');

			Route::delete('delete/{id}', 'Admin\SizeController@delete');

			Route::get('/listProduct/{id}','Admin\SizeController@anyDataProductBySize')->name('admin.size.listProduct.dataTable');

		});

		Route::group(['prefix' => 'colors'], function() {

			Route::get('/','Admin\ColorController@getIndex')->name('admin.color');

			Route::get('/listColor','Admin\ColorController@anyData')->name('admin.color.dataTable');

			Route::post('/store', 'Admin\ColorController@store')->name('admin.color.store');

			Route::get('edit/{id}', 'Admin\ColorController@edit');

			Route::put('update/{id}', 'Admin\ColorController@update');

			Route::delete('delete/{id}', 'Admin\ColorController@delete');

			Route::get('/listProduct/{id}','Admin\ColorController@anyDataProductByColor')->name('admin.color.listProduct.dataTable');

		});

		Route::group(['prefix' => 'orders'], function() {

			Route::get('/','Admin\OrderController@getIndex')->name('admin.order');

			Route::get('/listOrders','Admin\OrderController@anyData')->name('admin.order.dataTable');

			Route::post('/store', 'Admin\OrderController@store')->name('admin.order.store');

			Route::get('/listProduct/{id}','Admin\OrderController@anyDataProduct')->name('admin.order.listProduct.dataTable');

			Route::get('edit/{id}', 'Admin\OrderController@edit');

			Route::put('update/{id}', 'Admin\OrderController@update');

			Route::delete('delete/{id}', 'Admin\OrderController@delete');

		});

		Route::get('/file', function() {
		    return view('vendor.laravel-filemanager.test');
		});

	});
});


Route::get('/', 'Shop\HomeController@getIndex')->name('shop.home');

Route::get('product/{slug}', 'Shop\ProductController@product_details' );

Route::get('category/{slug}', 'Shop\ProductController@getProductByCategory' );

Route::get('brand/{slug}', 'Shop\ProductController@getProductByBrand' );

Route::post('add2cart', 'Shop\ProductController@add2cart')->name('add2cart');

Route::get('cart', 'Shop\ProductController@getCart')->name('getCart');

Route::get('all-item', 'Shop\ProductController@getAllItemPage')->name('all-item');

Route::get('updateCart/increase/{rowId}', 'Shop\ProductController@increase');

Route::get('updateCart/decrease/{rowId}', 'Shop\ProductController@decrease');

Route::post('checkout', 'Shop\ProductController@checkout')->name('checkout');