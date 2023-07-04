<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Http\Request;

class BERoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        if ($roles->isEmpty()) {
            return response()->json('No results found!');
        }
        return response()->json(['role' => $roles]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|unique:role',
        ]);
        Role::store($validatedData);
        return response()->json('Created successfully !', 201);
    }

    public function delete($id){
        if(Role::find($id) == null)
            return response()->json('Id doesn`t exist !');
        Role::destroy($id);
        return response()->json('Delete successfully !', 201);
    }

    public function update(Request $request, $id){
        if(Role::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $validatedData = $request->validate([
            'name' => 'required|unique:role',
        ]);
        Role::edit($id,$validatedData);
        return response()->json('Update successfully !', 201);
    }
}
