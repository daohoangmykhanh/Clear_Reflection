<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Illuminate\Http\Request;

class OrderAddressController extends Controller
{
    public function index()
    {
        $orderAddresses = OrderAddress::all();

        return response()->json([
            'order_addresses' => $orderAddresses,
        ]);
    }

    public function show($id)
    {
        $orderAddress = OrderAddress::findOrFail($id);

        return response()->json([
            'order_address' => $orderAddress,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);

        $orderAddress = OrderAddress::create($validatedData);

        return response()->json([
            'order_address' => $orderAddress,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'address_id' => 'required|integer',
            'order_id' => 'required|integer',
        ]);

        $orderAddress = OrderAddress::findOrFail($id);
        $updated = $orderAddress->update($validatedData);

        return response()->json($updated);
    }

    public function destroy($id)
    {
        $orderAddress = OrderAddress::findOrFail($id);
        $deleted = $orderAddress->delete();

        return response()->json($deleted);
    }
}
