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

        return response()->json([
            'addresses' => $addresses,
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
            'address' => $address,
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
            'address' => $address,
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

        return response()->json($updated);
    }

    /**
     * Xóa một địa chỉ cụ thể khỏi cơ sở dữ liệu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $deleted = $address->delete();

        return response()->json($deleted);
    }
}
