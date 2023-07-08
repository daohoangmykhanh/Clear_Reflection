<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BEAccountController extends Controller
{
    public function index(){
        $accounts = Account::all();
        if($accounts -> isEmpty()){
            return response()->json([
                'result' => false,
                'message' => 'Delete successfully !'
            ]);
        }
        foreach($accounts as $account){
            $image = null;
            if ($account->image_id !== null) {
                $storagePath = public_path('images/account/');
                $filename = $account->image->image_url;
                $data = file_get_contents($storagePath. $filename);
                $base64Image = base64_encode($data);
                $image = [
                    'imageId' => $account->image->image_id,
                    'imageUrl' => $base64Image,
                ];
            }
            $role = $account->role;
            $accountData[] = [
                'accountId' => $account->account_id,
                'password' => $account->password,
                'fullName' => $account->full_name,
                'email' => $account->email,
                'phoneNumber' => $account->phone_number,
                'image' => $image,
                'role' => [
                    'roleId' => $role->role_id,
                    'name' => $role->name,
                ],
                'createdAt' => $account->created_at,
                'updatedAt' => $account->updated_at,
            ];
        }
        return response()->json($accountData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'password' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'roleId' => 'required',
            'image' => 'required|string',
        ]);
        $result = Account::store($validatedData);
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Created unsuccessfully !'
            ]);

        return response()->json([
            'result' => true,
            'message' => 'Created successfully !'
        ]);
    }

    public function edit($id){
        $account = Account::Find($id);
        if($account == null )
            return response()->json('Id doesn`t exist !');

        return response()->json($account);
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'account_id' => 'required',
            'password' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'image_id' => 'nullable',
        ]);

        $result = Account::edit($validatedData);
        if(!$result)
            return response()->json('Updated unsuccessfully !');

        return response()->json('Updated successfully !', 201);
    }

    public function delete($id){
        if(Account::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $result = Account::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');

        return response()->json('Deleted successfully !', 201);
    }
}
