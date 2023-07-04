<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    /**
     * Hiển thị danh sách tất cả các Province.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    /**
     * Hiển thị thông tin của một Province cụ thể.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $province = Province::where('code', $id)->firstOrFail();
        return response()->json($province);
    }

    /**
     * Lưu một Province mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $province = Province::create($request->all());
        return response()->json($province, 201);
    }

    /**
     * Cập nhật thông tin của một Province cụ thể trong cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);
        $province->update($request->all());
        return response()->json($province);
    }

    /**
     * Xóa một Province cụ thể khỏi cơ sở dữ liệu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $province = Province::where('code', $id)->firstOrFail();
        $province->delete();
        return response()->json(['message' => 'Province deleted']);
    }
}
