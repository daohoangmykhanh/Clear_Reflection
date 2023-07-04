<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $addresses = Address::all();
        foreach ($addresses as $address) {
            $addressData[] = [
                'address_id' => $address->address_id,
                'house_number' => $address->house_number,
                'road_name' => $address->road_name,
                'wards_code' => $address->wards_code,
                'district_code' => $address->district,
                'province_code' => $address->province,
                "ward" => $address->ward,
            ];
        }
        return response()->json($addresses);
    }


    public function store(Request $request)
    {

        $address = Address::create($request->all());

        return response()->json($address, 201);
    }


    public function show($id)
    {
        $address = Address::findOrFail($id);

        return response()->json($address);
    }


    public function update(Request $request, $id)
    {

        $address = Address::findOrFail($id);
        $address->update($request->all());

        return response()->json($address);
    }


    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Address deleted']);
    }
}
