<?php

namespace App\Http\Controllers;

use App\Models\CompanyAddress;
use Illuminate\Http\Request;

class AddressCompanyController extends Controller
{
    public function index()
    {
        $addressCompanies = CompanyAddress::all();
        foreach ($addressCompanies as $addressCompany) {
            $address = $addressCompany->address;
            $companyInformation = $addressCompany->companyInformation;
            $addressData[] = [
                'id' => $addressCompany->id,
                'address' => [
                    "address_id" => $address->address_id,
                    "house_number" => $address->house_number,
                    "road_name" => $address->road_name,
                    "district" => $address->district->full_name,
                    "province" => $address->province->full_name,
                ],
                'company_information' => [
                    "company_information_id" => $companyInformation->company_information_id,
                    "company_name" => $companyInformation->company_name,
                    "company_address" => $companyInformation->company_address,
                    "company_phone_number" => $companyInformation->company_phone_number,
                    "company_vat_number" => $companyInformation->company_vat_number,
                ]
            ];
        }
        return response()->json($addressData);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'address_id' => 'required',
            'company_information_id' => 'required',
        ]);

        $addressCompany = CompanyAddress::create($validatedData);

        return response()->json($addressCompany, 201);
    }

    public function show($id)
    {
        $addressCompany = CompanyAddress::findOrFail($id);

        $address = $addressCompany->address;
        $companyInformation = $addressCompany->companyInformation;

        $addressData = [
            'id' => $addressCompany->id,
            'address' => [
                "address_id" => $address->address_id,
                "house_number" => $address->house_number,
                "road_name" => $address->road_name,
                "district" => $address->district->full_name,
                "province" => $address->province->full_name,
            ],
            'company_information' => [
                "company_information_id" => $companyInformation->company_information_id,
                "company_name" => $companyInformation->company_name,
                "company_address" => $companyInformation->company_address,
                "company_phone_number" => $companyInformation->company_phone_number,
                "company_vat_number" => $companyInformation->company_vat_number,
            ]
        ];

        return response()->json($addressData);
    }

    public function update(Request $request, $id)
    {
        $addressCompany = CompanyAddress::findOrFail($id);
        $updated = $addressCompany->update($request->all());

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Address company updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update address company.',
            ]);
        }
    }

    public function destroy($id)
    {
        $addressCompany = CompanyAddress::findOrFail($id);
        $deleted = $addressCompany->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Address company deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete address company.',
            ]);
        }
    }
}
