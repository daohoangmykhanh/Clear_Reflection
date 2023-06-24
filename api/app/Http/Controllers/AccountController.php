<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index(){
        $accounts = Account::all();
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
}
