<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::all();
        $districtData = [];

        foreach ($districts as $district) {
            $districtData[] = [
                'code' => $district->code,
                'name' => $district->name,
                'name_en' => $district->name_en,
                'full_name' => $district->full_name,
                'full_name_en' => $district->full_name_en,
                'code_name' => $district->code_name,
                'province_code' => $district->province_code,
                'administrative_unit_id' => $district->administrative_unit_id,
            ];
        }

        return response()->json([
            'districts' => $districtData,
        ]);
    }


    public function show($code)
    {
        $district = District::findOrFail($code);

        return response()->json([
            'district' => [
                'code' => $district->code,
                'name' => $district->name,
                'name_en' => $district->name_en,
                'full_name' => $district->full_name,
                'full_name_en' => $district->full_name_en,
                'code_name' => $district->code_name,
                'province_code' => $district->province_code,
                'administrative_unit_id' => $district->administrative_unit_id,
            ]
        ]);
    }

    public function getAllDistrictsByProvince($provinceCode)
    {
        $districts = District::where('province_code', $provinceCode)->get();
        $districtData = [];

        foreach ($districts as $district) {
            $districtData[] = [
                'code' => $district->code,
                'name' => $district->name,
            ];
        }

        return response()->json([
            'districts' => $districtData
        ]);
    }
}
