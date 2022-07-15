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

Route::get('/map', function () {
    return view('map');
});

Route::get('/', 'App\Http\Controllers\WelcomeController@index')->name('welcome');
Route::get('/maps', 'App\Http\Controllers\MapsController@index')->name('maps');

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user/shopping', 'App\Http\Controllers\user\ShoppingController@index')->name('user-shopping');

    /* shopping & category */
    Route::get('/user/details/{id}', 'App\Http\Controllers\user\ShoppingController@details')->name('user-product-details');
    Route::get('/user/category/{id}', 'App\Http\Controllers\user\ShoppingController@category')->name('user-product-category');

    /* cart routes */
    Route::get('/user/cart', 'App\Http\Controllers\user\ShoppingController@cart')->name('user-cart');
    Route::get('/add/cart/{id}', 'App\Http\Controllers\user\ShoppingController@add_cart')->name('add-cart');
    Route::get('/cart/increase/quantity/{cart_id}', 'App\Http\Controllers\user\ShoppingController@increase_cart')->name('increase-cart');
    Route::get('/cart/decrease/quantity/{cart_id}', 'App\Http\Controllers\user\ShoppingController@decrease_cart')->name('decrease-cart');
    Route::get('/delete/cart/{cart_id}', 'App\Http\Controllers\user\ShoppingController@delete_cart')->name('delete-cart');

    /*checkout routes*/
    Route::get('/user/checkout', 'App\Http\Controllers\user\OrderController@index')->name('user-checkout');
    Route::post('/user/checkout/post', 'App\Http\Controllers\user\OrderController@checkout')->name('user-checkout-post');

    /*orders routes*/
    Route::get('/user/orders', 'App\Http\Controllers\user\OrderController@myorders')->name('user-orders');

    /*shipment track routes*/
    Route::get('/user/tracking/{id}', 'App\Http\Controllers\user\TrackController@index')->name('user-track');

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

    //orders
    Route::get('/admin/orders', 'App\Http\Controllers\admin\OrderController@index')->name('admin-orders');
    Route::post('/admin/add/shipment', 'App\Http\Controllers\admin\OrderController@ship')->name('admin-add-shipments');

    //Category
    Route::get('/admin/checkpoints', 'App\Http\Controllers\admin\CheckPointController@index')->name('admin-checkpoints');
    Route::post('/admin/add/CheckPoint', 'App\Http\Controllers\admin\CheckPointController@add')->name('admin-add-checkpoints');
    Route::post('/admin/edit/CheckPoint', 'App\Http\Controllers\admin\CheckPointController@edit')->name('admin-edit-checkpoints');
    Route::post('/admin/delete/CheckPoint', 'App\Http\Controllers\admin\CheckPointController@delete')->name('admin-delete-checkpoints');

    //transporter
    Route::get('/admin/transporters', 'App\Http\Controllers\admin\TransporterController@index')->name('admin-transporters');
    Route::post('/admin/add/transporter', 'App\Http\Controllers\admin\TransporterController@add')->name('admin-add-transporters');
    Route::post('/admin/edit/transporter', 'App\Http\Controllers\admin\TransporterController@edit')->name('admin-edit-transporters');
    Route::post('/admin/delete/transporter', 'App\Http\Controllers\admin\TransporterController@delete')->name('admin-delete-transporters');

    //user
    Route::get('/admin/users', 'App\Http\Controllers\admin\UserController@index')->name('admin-users');
    Route::post('/admin/edit/user', 'App\Http\Controllers\admin\UserController@edit')->name('admin-edit-users');

});

Route::group(['middleware'=>['auth', 'role:transporter']], function (){
    Route::get('/transporter/dashboard', 'App\Http\Controllers\transporter\DashboardController@index')->name('transporter-dashboard');

    //old shipments
    Route::get('/transporter/shipments', 'App\Http\Controllers\transporter\ShipmentController@index')->name('transporter-shipments');

});

require __DIR__.'/auth.php';
