<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các Ward.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wards = Ward::all();
        return response()->json($wards);
    }

    /**
     * Hiển thị thông tin của một Ward cụ thể.
     *

     */
    public function show($id)
    {
        $ward = Ward::whereRaw("BINARY code = ?", [$id])->firstOrFail();
        return $ward;
    }

    /**
     * Lưu một Ward mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ward = Ward::create($request->all());
        return response()->json($ward, 201);
    }

    /**
     * Cập nhật thông tin của một Ward cụ thể trong cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);
        $ward->update($request->all());
        return response()->json($ward);
    }

    /**
     * Xóa một Ward cụ thể khỏi cơ sở dữ liệu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $ward->delete();
        return response()->json(['message' => 'Ward deleted']);
    }
}
