<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Order;
class BEAccountController extends Controller
{
    public function index(){
        $accounts = Account::all();
        if($accounts -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($accounts as $account){
            $order = Order::where('account_id', $account -> account_id) -> get() -> count();
            $role = $account->role;
            $accountData[] = [
                'accountId' => $account->account_id,
                'username' => $account->username,
                'password' => $account->password,
                'fullName' => $account->full_name,
                'email' => $account->email,
                'phoneNumber' => $account->phone_number,
                'imageId' => $account->image_id,
                'role' => [
                    'roleId' => $role->role_id,
                    'name' => $role->name,
                ],
                'order' => $order,
                'createdAt' => $account->created_at,
                'updatedAt' => $account->updated_at,
            ];
        }
        return response()->json($accountData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|unique:account,username',
            'password' => 'required',
            'fullName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'image' => 'nullable',
        ]);
        $account = new Account();
        $account -> username = $validatedData['username'];
        $account -> password = bcrypt($validatedData['password']);
        $account -> full_name = $validatedData['fullName'];
        $account -> email = $validatedData['email'];
        $account -> phone_number = $validatedData['phoneNumber'];
        $account -> role_id = 2;

        $image = new Image();
        $base64String = $validatedData['image'];
        $base64Data = substr($base64String, strpos($base64String, ',') + 1);
        $imageData = base64_decode($base64Data);
        $filename = uniqid() . '.png';
        $storagePath = public_path('images/account/');
        file_put_contents($storagePath. $filename, $imageData);
        $image->image_url = $filename;
        $image->save();

        $account -> image_id = $image -> image_id;
        $result = $account -> save();

        if(!$result)
            return response()->json([
                    'result' => false,
                    'message' => 'Created unsuccessfully'
            ]);

        return response()->json($account);
    }

    public function edit($id){
        $account = Account::Find($id);
        if($account == null )
            return response()->json('Id doesn`t exist !');

        return response()->json($account);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'password' => 'nullable',
            'fullName' => 'required',
            'email' => 'required|email',
            'phoneNumber' => 'required',
            'image' => 'nullable',
        ]);
        $account = Account::Find($id);
        if(isset($validatedData['password'])){
            $account -> password = bcrypt($validatedData['password']);
        }
        $account -> email = $validatedData['email'];
        $account -> phone_number = $validatedData['phoneNumber'];
        if(isset($validatedData['image'])){
            if($account -> image_id != null){
                $oldImageFilename = $account -> image -> image_url;
                $oldImagePath = public_path('images/account/') . $oldImageFilename;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
                $image = Image::find($account->image_id);
            }else {
                $image = new Image();
            }
            $base64String = $validatedData['image'];
            $base64Data = substr($base64String, strpos($base64String, ',') + 1);
            $imageData = base64_decode($base64Data);
            $filename = uniqid() . '.png';
            $storagePath = public_path('images/account/');
            file_put_contents($storagePath. $filename, $imageData);
            $image -> image_url = $filename;
            $image -> save();
            $account -> image_id = $image -> image_id;
        }
        $result = $account -> save();
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Updated unsuccessfully'
            ]);

            return response()->json([
                'result' => true,
                'message' => 'Updated successfully'
            ]);
    }
}
