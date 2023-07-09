<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        $provinceData = [];

        foreach ($provinces as $province) {
            $provinceData[] = [
                'code' => $province->code,
                'name' => $province->name,
            ];
        }

        return response()->json([
            'provinces' => $provinceData,
        ]);
    }

    public function show($id)
    {
        $province = Province::where('code', $id)->firstOrFail();

        return response()->json([
            'province' =>  [
                'code' => $province->code,
                'name' => $province->name,
                'nameEn' => $province->name_en,
                'fullName' => $province->full_name,
                'fullNameEn' => $province->full_name_en,
                'codeName' => $province->code_name,
                'administrativeUnitId' => $province->administrative_unit_id,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $province = Province::create($request->all());

        return response()->json([
            'province' =>  [
                'code' => $province->code,
                'name' => $province->name,
                'nameEn' => $province->name_en,
                'fullName' => $province->full_name,
                'fullNameEn' => $province->full_name_en,
                'codeName' => $province->code_name,
                'administrativeUnitId' => $province->administrative_unit_id,
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $province = Province::findOrFail($id);
        $updated = $province->update($request->all());

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Province updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update province.',
            ]);
        }
    }

    public function destroy($id)
    {
        $province = Province::where('code', $id)->firstOrFail();
        $deleted = $province->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Province deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete province.',
            ]);
        }
    }
}
