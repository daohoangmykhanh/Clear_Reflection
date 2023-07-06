<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\WardController;
use App\Http\Controllers\AddressAccountController;
use App\Models\Ward;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\BERoleController;
use App\Http\Controllers\BEAccountController;
use App\Http\Controllers\BECategoryController;
use App\Http\Controllers\BEProductShapeController;
use App\Http\Controllers\BEProductStyleController;
use App\Http\Controllers\FEAccountController;
use App\Http\Controllers\BEProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ListProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\BECouponController;
use App\Http\Controllers\BECouponTypeController;
use App\Http\Controllers\BECompanyController;
use App\Http\Controllers\BEOrderController;
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
// Route::group(['prefix' => 'admin', 'middleware' => 'auth:api'], function () {}


Route::resource('product-variant', ProductVariantController::class);
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

Route::resource('product', ProductController::class);
// Product Controller
Route::get('/admin/product', [BEProductController::class, 'index']);
Route::get('/admin/product/a', [ListProductController::class, 'listDetail']);
Route::get('/admin/product/{product_id}', [ProductVariantController::class, 'show']);
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
Route::post('/admin/category/update/{id}', [BECategoryController::class, 'update']);
Route::get('/admin/category/delete/{id}', [BECategoryController::class, 'delete']);
// Product Shape Controller
Route::get('/admin/shape', [BEProductShapeController::class, 'index']);
Route::post('/admin/shape/create', [BEProductShapeController::class, 'create']);
Route::post('/admin/shape/update/{id}', [BEProductShapeController::class, 'update']);
Route::get('/admin/shape/delete/{id}', [BEProductShapeController::class, 'delete']);
// Product Style Controller
Route::get('/admin/style', [BEProductStyleController::class, 'index']);
Route::post('/admin/style/create', [BEProductStyleController::class, 'create']);
Route::post('/admin/style/update/{id}', [BEProductStyleController::class, 'update']);
Route::get('/admin/style/delete/{id}', [BEProductStyleController::class, 'delete']);
// FEAccount Controller
Route::post('/register', [FEAccountController::class, 'register']);
Route::post('/signin', [FEAccountController::class, 'signin']);
Route::post('/checkUsername', [FEAccountController::class, 'checkUsername']);
// BECoupon Controller
Route::get('/admin/coupon', [BECouponController::class, 'index']);
Route::post('/admin/coupon/create', [BECouponController::class, 'create']);
Route::post('/admin/coupon/update/{id}', [BECouponController::class, 'update']);
Route::get('/admin/coupon/delete/{id}', [BECouponController::class, 'delete']);
// BECouponType Controller
Route::get('/admin/coupontype', [BECouponTypeController::class, 'index']);
Route::post('/admin/coupontype/create', [BECouponTypeController::class, 'create']);
Route::post('/admin/coupontype/update/{id}', [BECouponTypeController::class, 'update']);
Route::get('/admin/coupontype/delete/{id}', [BECouponTypeController::class, 'delete']);
// BECompany Controller
Route::get('/admin/company', [BECompanyController::class, 'index']);
Route::post('/admin/company/update', [BECompanyController::class, 'update']);
// BEOrder Controller
Route::get('/admin/order', [BEOrderController::class, 'index']);
Route::get('/admin/order/{id}', [BEOrderController::class, 'detail']);
Route::post('/admin/order/create', [BECouponTypeController::class, 'create']);
Route::post('/admin/order/update/{id}', [BECouponTypeController::class, 'update']);
Route::get('/admin/order/delete/{id}', [BECouponTypeController::class, 'delete']);