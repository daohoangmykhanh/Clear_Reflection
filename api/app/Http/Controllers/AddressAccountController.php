<?php

namespace App\Http\Controllers;

use App\Models\AddressAccount;
use Illuminate\Http\Request;

class AddressAccountController extends Controller
{
    public function index()
    {
        $addressAccounts = AddressAccount::all();
        foreach ($addressAccounts as $addressAccount) {
            $address = $addressAccount->address;
            $account = $addressAccount->account;
            $addressData[] = [
                'id' => $addressAccount->id,
                'account' => [
                    'account_id' => $account->account_id,
                    'full_name' => $account->full_name,
                    'email' => $account->email,
                    'phone_number' => $account->phone_number,
                    'image_id' => $account->image_id,
                    'address' => $account->address,
                ],
                'address' => [
                    "address_id" => $address->address_id,
                    "house_number" => $address->house_number,
                    "road_name" => $address->road_name,
                    "district" => $address->district->full_name,
                    "province" => $address->province->full_name,
                ]
            ];
        }
        return response()->json($addressData);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address_id' => 'required',
            'account_id' => 'required',
        ]);

        $addressAccount = AddressAccount::create($validatedData);

        return response()->json($addressAccount, 201);
    }

    public function show($id)
    {
        $addressAccount = AddressAccount::findOrFail($id);

        $address = $addressAccount->address;
        $account = $addressAccount->account;
        $address = $addressAccount->address;
        $addressData = [
            'id' => $addressAccount->id,
            'account' => [
                'account_id' => $account->account_id,
                'full_name' => $account->full_name,
                'email' => $account->email,
                'phone_number' => $account->phone_number,
                'image_id' => $account->image_id,
                'address' => $account->address,
            ],
            'address' => [
                "address_id" => $address->address_id,
                "house_number" => $address->house_number,
                "road_name" => $address->road_name,
                "district" => $address->district->full_name,
                "province" => $address->province->full_name,
            ]
        ];

        return response()->json($addressData);
    }

    public function update(Request $request, $id)
    {
        $addressAccount = AddressAccount::findOrFail($id);
        $updated = $addressAccount->update($request->all());

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Address account updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update address account.',
            ]);
        }
    }

    public function destroy($id)
    {
        $addressAccount = AddressAccount::findOrFail($id);
        $deleted = $addressAccount->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Address account deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete address account.',
            ]);
        }
    }
}
