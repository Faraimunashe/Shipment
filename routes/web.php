<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'App\Http\Controllers\WelcomeController@index')->name('welcome');

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user/shopping', 'App\Http\Controllers\user\ShoppingController@index')->name('user-shopping');

    /* cart routes */
    Route::get('/user/cart', 'App\Http\Controllers\user\ShoppingController@cart')->name('user-cart');
    Route::get('/add/cart/{id}', 'App\Http\Controllers\user\ShoppingController@add_cart')->name('add-cart');
    Route::get('/cart/increase/quantity/{cart_id}', 'App\Http\Controllers\user\ShoppingController@increase_cart')->name('increase-cart');
    Route::get('/cart/decrease/quantity/{cart_id}', 'App\Http\Controllers\user\ShoppingController@decrease_cart')->name('decrease-cart');
    Route::get('/delete/cart/{cart_id}', 'App\Http\Controllers\user\ShoppingController@delete_cart')->name('delete-cart');

    /*checkout routes*/
    Route::get('/user/checkout', 'App\Http\Controllers\user\OrderController@index')->name('user-checkout');
    Route::post('/user/checkout/post', 'App\Http\Controllers\user\OrderController@checkout')->name('user-checkout-post');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\admin\DashboardController@index')->name('admin-dashboard');

    //Category
    Route::get('/admin/categories', 'App\Http\Controllers\admin\CategoryController@index')->name('admin-categories');
    Route::post('/admin/add/category', 'App\Http\Controllers\admin\CategoryController@add')->name('admin-add-categories');
    Route::post('/admin/edit/category', 'App\Http\Controllers\admin\CategoryController@edit')->name('admin-edit-categories');
    Route::post('/admin/delete/category', 'App\Http\Controllers\admin\CategoryController@delete')->name('admin-delete-categories');

    //product
    Route::get('/admin/products', 'App\Http\Controllers\admin\ProductController@index')->name('admin-products');
    Route::post('/admin/add/product', 'App\Http\Controllers\admin\ProductController@add')->name('admin-add-products');
    Route::post('/admin/edit/product', 'App\Http\Controllers\admin\ProductController@edit')->name('admin-edit-products');
    Route::post('/admin/delete/product', 'App\Http\Controllers\admin\ProductController@delete')->name('admin-delete-products');
});

require __DIR__.'/auth.php';
