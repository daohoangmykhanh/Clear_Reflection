<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::all();

        return response()->json([
            'wards' => $wards,
        ]);
    }

    public function show($id)
    {
        $ward = Ward::whereRaw("BINARY code = ?", [$id])->firstOrFail();

        return response()->json([
            'ward' => $ward,
        ]);
    }

    public function store(Request $request)
    {
        $ward = Ward::create($request->all());

        return response()->json([
            'ward' => $ward,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);
        $updated = $ward->update($request->all());

        return response()->json($updated ? true : false);
    }

    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $deleted = $ward->delete();

        return response()->json($deleted ? true : false);
    }

    public function getAllWardsByDistrict($districtCode)
    {
        $wards = Ward::where('district_code', $districtCode)->get();

        return response()->json([
            'wards' => $wards,
        ]);
    }
}
