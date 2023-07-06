<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();

        return response()->json([
            'districts' => $districts,
        ]);
    }

    public function show($code)
    {
        $district = District::findOrFail($code);

        return response()->json([
            'district' => $district,
        ]);
    }

    public function getAllDistrictsByProvince($provinceCode)
    {
        $districts = District::where('province_code', $provinceCode)->get();

        return response()->json([
            'districts' => $districts,
        ]);
    }
}
