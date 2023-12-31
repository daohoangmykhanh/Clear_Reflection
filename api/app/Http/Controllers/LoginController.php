<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use HTTP_OK;
use Illuminate\Support\Facades\Hash;
use App\Mail\VerifyEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['index', 'register']]);
    // }
    public function register(Request $request)
    {
        // $request->validate([
        //     'full_name' => 'required|string|max:255',
        //     'email' => 'required|string|email|max:255|unique:account',
        //     'password' => 'required|string',
        // ]);
        // dd(123);

        $user = Account::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => ($request->phone_number),
            'full_name' => ($request->full_name),
        ]);

        // $name = "ádsđá";
        // Mail::send("email", compact('name'), function ($email) {
        //     $email->to($request->email);
        // });
        return response()->json([
            "result" => true,
            'message' => 'User created successfully',
        ]);
    }

    public function index(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!($token = JWTAuth::attempt($credentials))) {
            return response()->json([
                'result' => false,
                'message' => 'Invalid Credentials.'
            ]);
        }

        return response()->json([
            'token' => $token,
        ]);
    }
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged out',
        ]);
    }
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
}
