<?php

namespace App\Http\Controllers;

use App\Models\OrderAddress;
use Illuminate\Http\Request;

class OrderAddressController extends Controller
{
    public function index()
    {
        $orderAddresses = OrderAddress::all();
        $orderAddressData = [];

        foreach ($orderAddresses as $orderAddress) {
            $orderAddressData[] = [
                'id' => $orderAddress->id,
                'addressId' => $orderAddress->address_id,
                'orderId' => $orderAddress->order_id,
            ];
        }

        return response()->json([
            'order_addresses' => $orderAddressData,
        ]);
    }


    public function show($id)
    {
        $orderAddress = OrderAddress::findOrFail($id);

        return response()->json([
            'order_address' => [
                'id' => $orderAddress->id,
                'addressId' => $orderAddress->address_id,
                'orderId' => $orderAddress->order_id,
            ]
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
            'order_address' => [
                'id' => $orderAddress->id,
                'addressId' => $orderAddress->address_id,
                'orderId' => $orderAddress->order_id,
            ]
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

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Order address updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update order address.',
            ]);
        }
    }

    public function destroy($id)
    {
        $orderAddress = OrderAddress::findOrFail($id);
        $deleted = $orderAddress->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Order address deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete order address.',
            ]);
        }
    }
}
