<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/forbidden', function () {
    return view('index');
})->name('forbidden');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::prefix('admin')->middleware(['auth','admin'])->group(function () {
    ///-------- main Route ---------///
    Route::get('/',[\App\Http\Controllers\Admin\PanelController::class,'index'])->name('panel');

    ///-------- user and roles Route ---------///
    Route::resource('/users',\App\Http\Controllers\Admin\UserController::class);
    Route::resource('/roles',\App\Http\Controllers\Admin\RoleController::class);
    Route::get('create_user_role/{id}',[\App\Http\Controllers\Admin\UserController::class,'createUserRoles'])->name('create.user.roles');
    Route::post('store_user_role/{id}',[\App\Http\Controllers\Admin\UserController::class,'storeUserRoles'])->name('store.user.roles');

    ///-------- logs Route ---------///
    Route::get('logs',[\App\Http\Controllers\Admin\LogViewerController::class,'index'])->name('logs');

    ///-------- Categories ---------///
    Route::resource('category',\App\Http\Controllers\Admin\CategoryController::class);

    ///-------- Sliders ---------///
    Route::resource('sliders',\App\Http\Controllers\Admin\SliderController::class);

    ///-------- Sliders ---------///
    Route::resource('brands',\App\Http\Controllers\Admin\BrandController::class);

    ///-------- Colors ---------///
    Route::resource('colors',\App\Http\Controllers\Admin\ColorController::class);

    ///-------- Products ---------///
    Route::resource('products',\App\Http\Controllers\Admin\ProductController::class);

    ///-------- Gallery ---------///
    Route::get('create_product_gallery/{id}',[\App\Http\Controllers\Admin\GalleryController::class,'addGallery'])->name('create.product.gallery');
    Route::post('store_product_gallery/{id}',[\App\Http\Controllers\Admin\GalleryController::class,'storeGallery'])->name('store.product.gallery');

    ///-------- PropertyGroups ---------///
    Route::resource('property_groups',\App\Http\Controllers\Admin\PropertyGroupController::class);

    ///-------- Properties ---------///
    Route::resource('properties',\App\Http\Controllers\Admin\PropertyController::class);

    ///-------- Gallery ---------///
    Route::get('create_product_properties/{id}',[\App\Http\Controllers\Admin\ProductController::class,'addProperties'])->name('create.product.properties');
    Route::post('store_product_properties/{id}',[\App\Http\Controllers\Admin\ProductController::class,'storeProperties'])->name('store.product.properties');

    ///---------- Orders ------///
    Route::get('order',[\App\Http\Controllers\Admin\OrderController::class,'orders'])->name('orders.panel');
    Route::get('order_detail/{id}',[\App\Http\Controllers\Admin\OrderController::class,'orderDetail'])->name('orders.details.panel');

});
