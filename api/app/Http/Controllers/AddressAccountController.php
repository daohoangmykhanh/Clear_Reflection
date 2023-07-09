<?php

namespace App\Http\Controllers;

use App\Models\AddressAccount;
use Illuminate\Http\Request;

class AddressAccountController extends Controller
{
    public function index()
    {
        $addressAccounts = AddressAccount::all();
        if($addressAccounts -> isEmpty())
            return response()->json('No result found!');
        foreach ($addressAccounts as $addressAccount) {
            $address = $addressAccount->address;
            $account = $addressAccount->account;
            $addressData[] = [
                'id' => $addressAccount->id,
                'account' => [
                    'accountId' => $account->id,
                    'fullName' => $account->full_name,
                    'email' => $account->email,
                    'phoneNumber' => $account->phone_number,
                    'imageId' => $account->image_id,
                    'address' => $account->address,
                ],
                'address' => [
                    "addressId" => $address->address_id,
                    "roadName" => $address->road_name,
                    "ward" => $address->ward->full_name,
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
            'addressId' => 'required',
            'accountId' => 'required',
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
                'accountId' => $account->id,
                'fullName' => $account->full_name,
                'email' => $account->email,
                'phoneNumber' => $account->phone_number,
                'imageId' => $account->image_id,
                'address' => $account->address,
            ],
            'address' => [
                "addressId" => $address->address_id,
                "roadName" => $address->road_name,
                "ward" => $address->ward->full_name,
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
