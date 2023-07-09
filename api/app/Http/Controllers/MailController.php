<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request, Account $account)
    {
        $name = "ádsđá";
        Mail::send("email", compact('name'), function ($email) {
            $email->to('hungn12323@gmail.com')  ;
        });
    }
}
