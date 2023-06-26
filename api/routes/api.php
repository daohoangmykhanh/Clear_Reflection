<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BERoleController;
use App\Http\Controllers\BEAccountController;
use App\Http\Controllers\BECategoryController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
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