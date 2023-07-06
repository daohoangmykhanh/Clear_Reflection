<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::all();
        $wardData = [];

        foreach ($wards as $ward) {
            $wardData[] = [
                'code' => $ward->code,
                'name' => $ward->name,
                'nameEn' => $ward->name_en,
                'fullName' => $ward->full_name,
                'fullNameEn' => $ward->full_name_en,
                'codeName' => $ward->code_name,
                'districtCode' => $ward->district_code,
                'administrativeUnitId' => $ward->administrative_unit_id,
            ];
        }

        return response()->json([
            'wards' => $wardData,
        ]);
    }


    public function show($id)
    {
        $ward = Ward::whereRaw("BINARY code = ?", [$id])->firstOrFail();

        return response()->json([
            'ward' => [
                'code' => $ward->code,
                'name' => $ward->name,
                'nameEn' => $ward->name_en,
                'fullName' => $ward->full_name,
                'fullNameEn' => $ward->full_name_en,
                'codeName' => $ward->code_name,
                'districtCode' => $ward->district_code,
                'administrativeUnitId' => $ward->administrative_unit_id,
            ]
        ]);
    }

    public function store(Request $request)
    {
        $ward = Ward::create($request->all());

        return response()->json([
            'ward' => [
                'code' => $ward->code,
                'name' => $ward->name,
                'nameEn' => $ward->name_en,
                'fullName' => $ward->full_name,
                'fullNameEn' => $ward->full_name_en,
                'codeName' => $ward->code_name,
                'districtCode' => $ward->district_code,
                'administrativeUnitId' => $ward->administrative_unit_id,
            ]
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $ward = Ward::findOrFail($id);
        $updated = $ward->update($request->all());

        return response()->json([
            'result' => $updated ? true : false,
            'message' => $updated ? 'Ward updated successfully.' : 'Failed to update ward.',
        ]);
    }

    public function destroy($id)
    {
        $ward = Ward::findOrFail($id);
        $deleted = $ward->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Ward deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete ward.',
            ]);
        }
    }
}
