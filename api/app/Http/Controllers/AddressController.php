<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các địa chỉ.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $addresses = Address::all();
        $addressData = [];

        foreach ($addresses as $address) {
            $addressData[] = [
                'address_id' => $address->address_id,
                'house_number' => $address->house_number,
                'road_name' => $address->road_name,
                'wards_code' => $address->wards_code,
                'district_code' => $address->district_code,
                'province_code' => $address->province_code,
            ];
        }

        return response()->json([
            'addresses' => $addressData,
        ]);
    }


    /**
     * Lưu một địa chỉ mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $address = Address::create($request->all());

        return response()->json([
            'address' => [
                'address_id' => $address->address_id,
                'house_number' => $address->house_number,
                'road_name' => $address->road_name,
                'wards_code' => $address->wards_code,
                'district_code' => $address->district_code,
                'province_code' => $address->province_code,
            ]
        ], 201);
    }

    /**
     * Hiển thị thông tin của một địa chỉ cụ thể.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $address = Address::findOrFail($id);

        return response()->json([
            'address' => [
                'address_id' => $address->address_id,
                'house_number' => $address->house_number,
                'road_name' => $address->road_name,
                'wards_code' => $address->wards_code,
                'district_code' => $address->district_code,
                'province_code' => $address->province_code,
            ]
        ]);
    }

    /**
     * Cập nhật thông tin của một địa chỉ cụ thể trong cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);
        $updated = $address->update($request->all());

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Address updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update address.',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $deleted = $address->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Address deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete address.',
            ], 500);
        }
    }
}
