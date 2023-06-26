<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class BEAccountController extends Controller
{
    public function index(){
        $accounts = Account::all();
        if($accounts -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($accounts as $account){
            $role = $account->role; 
            $accountData[] = [
                'account_id' => $account->account_id,
                'username' => $account->username,
                'password' => $account->password,
                'full_name' => $account->full_name,
                'email' => $account->email,
                'phone_number' => $account->phone_number,
                'image_id' => $account->image_id,
                'address' => $account->address,
                'role' => [
                    'role_id' => $role->role_id,
                    'name' => $role->name,
                ],
                'created_at' => $account->created_at,
                'updated_at' => $account->updated_at,
            ];
        }
        return response()->json($accountData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|unique:account',
            'password' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'role_id' => 'required',
            'image_id' => 'nullable',
        ]);
        $result = Account::store($validatedData);
        if(!$result)
            return response()->json('Created unsuccessfully !');
        
        return response()->json('Created successfully !', 201);
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
            'full_name' => 'required',
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
