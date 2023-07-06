<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();

        return response()->json([
            'provinces' => $provinces,
        ]);
    }

    public function show($id)
    {
        $province = Province::where('code', $id)->firstOrFail();

        return response()->json([
            'province' => $province,
        ]);
    }

    public function store(Request $request)
    {
        $province = Province::create($request->all());

        return response()->json([
            'province' => $province,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);
        $updated = $province->update($request->all());

        return response()->json($updated ? true : false);
    }

    public function destroy($id)
    {
        $province = Province::where('code', $id)->firstOrFail();
        $deleted = $province->delete();

        return response()->json($deleted ? true : false);
    }
}
