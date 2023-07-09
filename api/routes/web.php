<?php

use App\Http\Controllers\LoginController;
use App\Models\Address;
use App\Models\Role;
use App\Models\Ward;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Request;
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

Route::post('/login', [LoginController::class, 'index']);


Route::post('/register', [LoginController::class, 'register']);


Route::middleware('checkApiAccess')->group(function () {
});
Route::post('/logout', [LoginController::class, 'logout']);
// Các route API yêu cầu xác thực và kiểm tra quyền truy cập
Route::post('/test', [LoginController::class, 'userProfile']);
