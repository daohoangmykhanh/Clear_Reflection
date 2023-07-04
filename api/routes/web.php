<?php

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

Route::get('/', function () {
    $addresses = Address::all();
    // foreach($addresses as $address){
    //     $addressData[] = [
    //         'address_id' => $address->address_id,
    //         'house_number' => $address->house_number,
    //         'road_name' => $address->road_name,
    //         'wards_code' => $address->wards_code,
    //         'district_code' => $address->district_code,
    //         'province_code' => $address->province_code,
    //         "ward" => $address ->ward,
    //     ];
    // }
    $ward = Ward::where('code', 6)->firstOrFail();
    return $ward;
});
