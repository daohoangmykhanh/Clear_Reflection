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



//address

Route::resource('address', AddressController::class);

//provinces
Route::resource('provinces', ProvinceController::class);
Route::resource('wards', WardController::class);
Route::resource('account-address', AddressAccountController::class);
