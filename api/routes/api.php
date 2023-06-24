<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccountController;


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
Route::get('/admin/role', [RoleController::class, 'index']);
Route::post('/admin/role/create', [RoleController::class, 'create']);
Route::get('/admin/role/delete/{id}', [RoleController::class, 'delete']);
// Account Controller
Route::get('/admin/account', [AccountController::class, 'index']);
