<?php

namespace App\Http\Controllers;
use App\Models\Account;
use App\Models\AccountCoupon;
use App\Models\CompanyInformation;
use App\Models\Coupon;
use Illuminate\Http\Request;

class BECompanyController extends Controller
{
    public function index(){
        $info = CompanyInformation::first();
        if($info == null){
            return response()->json('No results found!');
        }
        $infoData = [
            'companyName' => $info->company_name,
            'companyAddress' => $info->company_address,
            'companyPhoneNumber' => $info->company_phone_number,
            'companyVatNumber' => $info->company_vat_number,
        ];

        return response()->json($infoData);
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'companyName' => 'required',
            'companyAddress' => 'required',
            'companyPhoneNumber' => 'required',
            'companyVatNumber' => 'nullable',
        ]);
        $info = CompanyInformation::first();
        $info -> company_name = $validatedData['companyName'];
        $info -> company_address = $validatedData['companyAddress'];
        $info -> company_phone_number = $validatedData['companyPhoneNumber'];
        $info -> company_vat_number = $validatedData['companyVatNumber'];
        $result = $info -> save();
        if(!$result)
        return response()->json([
            'result' => false,
            'message' => 'Updated unsuccessfully.',
        ]);

        return response()->json([
            'result' => true,
            'message' => 'Updated successfully.',
        ]);
    }

}
