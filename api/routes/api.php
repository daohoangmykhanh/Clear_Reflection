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
use App\Http\Controllers\BEProductColorController;
use App\Http\Controllers\FEAccountController;
use App\Http\Controllers\BEProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\OrderAddressController;
use App\Http\Controllers\BECouponController;
use App\Http\Controllers\BECouponTypeController;
use App\Http\Controllers\BECompanyController;
use App\Http\Controllers\BEOrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
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


//image
Route::resource('image', CategoryController::class);

//category
Route::resource('category', CategoryController::class);

//order-address
Route::resource('order-address', OrderAddressController::class);

// district
Route::resource('districts', DistrictController::class);
Route::get('districts/{districtCode}/wards', [WardController::class, 'getAllWardsByDistrict']);


//product-variant
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
Route::get('provinces/{provinceCode}/districts', [DistrictController::class, 'getAllDistrictsByProvince']);


// ward
Route::resource('wards', WardController::class);
//account-ađress
Route::resource('account-address', AddressAccountController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// product
Route::resource('/product', ProductController::class);
Route::get('/product/sort/{value}', [ProductController::class, 'sortByRating']);


// Admin Routes
Route::prefix('/admin')->group(function () {
    // Product Routes
    Route::get('/product', [BEProductController::class, 'index']);
    Route::get('/product/detail/{id}', [BEProductController::class, 'detail']);
    Route::get('/product/hide/{id}', [BEProductController::class, 'hide']);
    Route::get('/product/{product_id}', [ProductVariantController::class, 'show']);
    Route::post('/product/create', [BEProductController::class, 'create']);
    Route::get('/product/edit/{id}', [BEProductController::class, 'edit']);
    Route::post('/product/update/{id}', [BEProductController::class, 'update']);
    Route::get('/product/delete/{id}', [BEProductController::class, 'delete']);

    // Role Routes
    Route::get('/role', [BERoleController::class, 'index']);
    Route::post('/role/create', [BERoleController::class, 'create']);
    Route::get('/role/delete/{id}', [BERoleController::class, 'delete']);

    // Account Routes
    Route::get('/account', [BEAccountController::class, 'index']);
    Route::post('/account/create', [BEAccountController::class, 'create']);
    Route::get('/account/detail/{id}', [BEAccountController::class, 'detail']);
    Route::post('/account/update/{id}', [BEAccountController::class, 'update']);

    // Category Routes
    Route::get('/category', [BECategoryController::class, 'index']);
    Route::post('/category/create', [BECategoryController::class, 'create']);
    Route::post('/category/update/{id}', [BECategoryController::class, 'update']);
    Route::get('/category/delete/{id}', [BECategoryController::class, 'delete']);

    // Product Shape Routes
    Route::get('/shape', [BEProductShapeController::class, 'index']);
    Route::post('/shape/create', [BEProductShapeController::class, 'create']);
    Route::post('/shape/update/{id}', [BEProductShapeController::class, 'update']);
    Route::get('/shape/delete/{id}', [BEProductShapeController::class, 'delete']);

    // Product Color Routes
    Route::get('/color', [BEProductColorController::class, 'index']);
    Route::post('/color/create', [BEProductColorController::class, 'create']);
    Route::post('/color/update/{id}', [BEProductColorController::class, 'update']);
    Route::get('/color/delete/{id}', [BEProductColorController::class, 'delete']);

    // Product Style Routes
    Route::get('/style', [BEProductStyleController::class, 'index']);
    Route::post('/style/create', [BEProductStyleController::class, 'create']);
    Route::post('/style/update/{id}', [BEProductStyleController::class, 'update']);
    Route::get('/style/delete/{id}', [BEProductStyleController::class, 'delete']);

    // Coupon Routes
    Route::get('/coupon', [BECouponController::class, 'index']);
    Route::post('/coupon/create', [BECouponController::class, 'create']);
    Route::post('/coupon/update/{id}', [BECouponController::class, 'update']);
    Route::get('/coupon/delete/{id}', [BECouponController::class, 'delete']);

    // Coupon Type Routes
    Route::get('/coupontype', [BECouponTypeController::class, 'index']);
    Route::post('/coupontype/create', [BECouponTypeController::class, 'create']);
    Route::post('/coupontype/update/{id}', [BECouponTypeController::class, 'update']);
    Route::get('/coupontype/delete/{id}', [BECouponTypeController::class, 'delete']);

    // Company Routes
    Route::get('/company', [BECompanyController::class, 'index']);
    Route::post('/company/update', [BECompanyController::class, 'update']);

    // Order Routes
    Route::get('/order', [BEOrderController::class, 'index']);
    Route::get('/order/{id}', [BEOrderController::class, 'detail']);
    Route::post('/order/create', [BEOrderController::class, 'create']);
    Route::post('/order/update/{id}', [BEOrderController::class, 'update']);
    Route::get('/order/{id}/order-status', [BEOrderController::class, 'findOrderStatusByOrderId']);

    Route::get('/findAllPayment', [BEOrderController::class, 'findAllPayment']);
    Route::get('/findAllStatus', [BEOrderController::class, 'findAllStatus']);
    Route::get('/customerByEmail/{keyword?}', [BEOrderController::class, 'customerByEmail']);
    Route::get('/productByIdOrName/{keyword?}', [BEOrderController::class, 'productByIdOrName']);
    Route::get('/isEmailExists/{email}', [BEOrderController::class, 'isEmailExists']);

    Route::get('/findSize/{id}', [BEOrderController::class, 'findSize']);
    Route::get('/findColor/{id}/{size}', [BEOrderController::class, 'findColor']);
    Route::get('/findPrice/{id}/{size}/{color}/', [BEOrderController::class, 'findPrice']);
    Route::get('/isCouponExists/{couponCode}', [BECouponController::class, 'isCouponExists']);
    Route::get('/findIdByCode/{couponCode}', [BECouponController::class, 'findIdByCode']);


});


// Auth Controller
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/test', [AuthController::class, 'test']);
// FEAccount Controller
Route::post('/register', [FEAccountController::class, 'register']);
Route::post('/signin', [FEAccountController::class, 'signin']);
Route::post('/checkUsername', [FEAccountController::class, 'checkUsername']);

// Home Controller
Route::post('/checkout', [HomeController::class, 'checkout']);
Route::get('/vnpay', [HomeController::class, 'vnpay']);
