<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Location\LocationController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register']);

Route::resource('categories', CategoryController::class);
Route::resource('types', TypeController::class);
Route::resource('brands', BrandController::class);
Route::resource('colors', ColorController::class);
Route::resource('products', ProductController::class);
Route::resource('posts', PostController::class);
Route::resource('carts', CartController::class);
Route::resource('orders', OrderController::class);
Route::resource('orderdetails', OrderDetailsController::class);
Route::resource('customers', CustomerController::class);

Route::post('/products/filters', [ProductController::class, 'filterProducts']);
Route::post('/products/search', [ProductController::class, 'searchProducts']);
Route::post('/getCart', [CartController::class, 'getCart']);

Route::post('getProvinces', [LocationController::class, 'getProvinces']);
Route::post('getDistricts', [LocationController::class, 'getDistricts']);
Route::post('getWards', [LocationController::class, 'getWards']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('accounts', AccountController::class);
    Route::resource('roles', RoleController::class);
    Route::post('change-password', [AuthController::class, 'changePasswordFirstLogin']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    
    Route::post('/upload', [ImageController::class, 'store'])->name('upload');
    Route::get('/media/{product}', [ImageController::class, 'getImages'])->name('product.images');
    Route::post('/products/upload_images', [ImageController::class, 'uploadImages'])->name('products.upload_images');
    Route::post('/products/delete_images', [ImageController::class, 'deleteImages'])->name('products.delete_images');
    Route::post('/posts/deleteImage', [PostController::class, 'deleteImage']);
  

    Route::post('handleOrder', [OrderController::class, 'handleOrder']);
    
    Route::post('logout', [AuthController::class, 'logout']);
});
