<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\AddressAccountController;
use App\Models\Ward;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BERoleController;
use App\Http\Controllers\BEAccountController;
use App\Http\Controllers\BECategoryController;
use App\Http\Controllers\FEAccountController;
use App\Http\Controllers\BEProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\CartController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// // Role Controller
// Route::get('/admin/role', [RoleController::class, 'index']);
// Route::post('/admin/role/create', [RoleController::class, 'create']);
// Route::get('/admin/role/delete/{id}', [RoleController::class, 'delete']);
// // Account Controller
// Route::get('/admin/account', [AccountController::class, 'index']);
// Route::prefix('api')->group(function () {
//     Route::resource('product-reviews', ProductReviewController::class);
// });
//cart
Route::resource('cart', CartController::class);
// product_reiew
Route::resource('product-review', ProductReviewController::class);
//wishlist
Route::resource('wishlist', WishlistController::class);
//address
Route::resource('address', AddressController::class);
//provinces
Route::resource('provinces', ProvinceController::class);
Route::resource('wards', WardController::class);
Route::resource('account-address', AddressAccountController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Product Controller
Route::get('/admin/product', [BEProductController::class, 'index']);
Route::get('/admin/product/listDetail', [BEProductController::class, 'listDetail']);
Route::post('/admin/product/create', [BEProductController::class, 'create']);
Route::get('/admin/product/{id}', [BEProductController::class, 'edit']);
Route::post('/admin/product/update', [BEProductController::class, 'update']);
Route::get('/admin/product/delete/{id}', [BEProductController::class, 'delete']);
// Role Controller
Route::get('/admin/role', [BERoleController::class, 'index']);
Route::post('/admin/role/create', [BERoleController::class, 'create']);
Route::get('/admin/role/delete/{id}', [BERoleController::class, 'delete']);
// Account Controller
Route::get('/admin/account', [BEAccountController::class, 'index']);
Route::post('/admin/account/create', [BEAccountController::class, 'create']);
Route::get('/admin/account/{id}', [BEAccountController::class, 'edit']);
Route::post('/admin/account/update', [BEAccountController::class, 'update']);
Route::get('/admin/account/delete/{id}', [BEAccountController::class, 'delete']);
// Category Controller
Route::get('/admin/category', [BECategoryController::class, 'index']);
Route::post('/admin/category/create', [BECategoryController::class, 'create']);
Route::get('/admin/category/{id}', [BECategoryController::class, 'edit']);
Route::post('/admin/category/update', [BECategoryController::class, 'update']);
Route::get('/admin/category/delete/{id}', [BECategoryController::class, 'delete']);

// FEAccount Controller
Route::post('/register', [FEAccountController::class, 'register']);
Route::post('/signin', [FEAccountController::class, 'signin']);
Route::post('/checkUsername', [FEAccountController::class, 'checkUsername']);
