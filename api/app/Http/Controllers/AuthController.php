<?php
namespace App\Http\Controllers;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function test(){
        $account = session('account');
        return response()->json($account);
    }

    public function register(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|unique:account',
            'password' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'imageId' => 'nullable',
        ]);
        $user = new Account();
        $user -> username = $validatedData['username'];
        $user -> email  = $validatedData['email'];
        $user -> phone_number  = $validatedData['phoneNumber'];
        $user -> full_name = $validatedData['fullName'];
        $user -> password = bcrypt($validatedData['password']);
        $user -> role_id = 2;
        $user -> save();
        return response()->json([
            'result' => true,
            'message' => 'Register successfully'
        ]);

    }
    public function logout (Request $request){
       $request->session()->flush();
        return response()->json([
            'result' => true,
            'message' => 'Logout successfully!'
        ]);
    }


}
