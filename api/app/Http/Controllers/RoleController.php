<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $role = Role::all();
        if($role == null)
            return response()->json('No results found !');
        
        return response()->json(['role' => $role]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|unique:role',
        ]);
        Role::store($validatedData);
        return response()->json('Role created successfully !', 201);
    }

    public function delete($id){
        if(Role::find($id) == null)
            return response()->json('Id doesn`t exist !');
        Role::destroy($id);
        return response()->json('Delete role successfully !', 201);
    }

    public function update(Request $request, $id){
        if(Role::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $validatedData = $request->validate([
            'name' => 'required|unique:role',
        ]);
        Role::edit()
    }
}
