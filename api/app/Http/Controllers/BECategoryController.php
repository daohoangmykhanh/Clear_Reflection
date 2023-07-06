<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class BECategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        if($categories -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($categories as $category){
            $categoryData[] = [
                'categoryId' => $category->category_id,
                'categoryName' => $category->category_name,
                'createdAt' => $category->created_at,
                'updatedAt' => $category->updated_at,
            ];
        }
        return response()->json($categoryData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'categoryName' => 'required|unique:category',
            'imageUrl' => 'required',
        ]);
        $category = new Category();
        $result = Category::store($validatedData);
        if(!$result)
            return response()->json('Created unsuccessfully !');

        return response()->json('Created successfully !', 201);
    }

    public function edit($id){
        $category = Category::Find($id);
        if($category == null )
            return response()->json("Id doesn't exist !");

        return response()->json($category);
    }

    public function update(Request $request){
        $id = $request -> category_id;
        $validatedData = $request->validate([
            'category_id' => 'required',
            'category_name' => 'required|unique:category,category_name,'. $id . ',category_id',
            'image_id' => 'nullable',
        ]);

        $result = Category::edit($validatedData);
        if(!$result)
            return response()->json('Updated unsuccessfully !');

        return response()->json('Updated successfully !', 201);
    }

    public function delete($id){
        if(Category::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $result = Category::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');

        return response()->json('Deleted successfully !', 201);
    }
}
