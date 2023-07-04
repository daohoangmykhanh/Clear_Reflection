<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Account;
use Illuminate\Http\Request;

class FEAccountController extends Controller
{
    public function register(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|unique:account',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'email' => 'required|email',
        ]);
        
        $result = DB::table('account') -> insert([
            'username' => $validatedData['username'],
            'password' => $validatedData['password'],
            'email' => $validatedData['email'],
            'role_id' => 2,
            'created_at' => now()
        ]);
        if(!$result)
            return response()->json('Register unsuccessfully !',400);
        
        return response()->json('Register successfully !', 201);
    }

    
    public function checkUsername(Request $request){
        $username = $request -> input('username');
        $existUser = DB::table('account')->where('username', $username)->exists();
        if ($existUser) {
            return response()->json('Username already exists', 409);
        } else {
            return response()->json('Username is available', 200);
        }
    }


}
