<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BECategoryController extends Controller
{
    public function index(){
        $categories = Category::all();
        if($categories -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($categories as $category){
            $image = null;
            if ($category->image_id !== null) {
                $image = [
                    'imageId' => $category->image->image_id,
                    'imageUrl' => $category->image->image_url,
                ];
            }
            $categoryData[] = [
                'categoryId' => $category->category_id,
                'categoryName' => $category->category_name,
                'image' => $image,
                'createdAt' => $category->created_at,
                'updatedAt' => $category->updated_at,
            ];
        }
        return response()->json($categoryData);
    }

    public function create(Request $request){
        try {
            $validatedData = $request->validate([
                'categoryName' => 'required|unique:category,category_name',
                'imageUrl' => 'nullable',
            ]);
            $cate = new Category();
            $cate -> category_name = $validatedData['categoryName'];
            if(isset($validatedData['imageUrl'])){
                $image = new Image();
                $base64String = $validatedData['imageUrl'];
                $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                $imageData = base64_decode($base64Data);
                $filename = uniqid() . '.png'; 
                $storagePath = public_path('images/category/');
                file_put_contents($storagePath. $filename, $imageData);
                $image->image_url = $filename;
                $image->save();
                $cate -> image_id = $image -> image_id;
            }
            $result = $cate -> save();
            if(!$result)
                return response()->json([
                    'result' => false,
                    'message' => 'Created unsuccessfully !'
                ]);
            
            return response()->json($cate, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        }
    }
    public function update(Request $request, $id){
        
        try {
            $validatedData = $request->validate([
                'categoryName' => 'required|unique:category,category_name,'. $id . ',category_id',
                'imageUrl' => 'nullable',
            ]);
            $cate = Category::find($id);
            $cate -> category_name = $validatedData['categoryName'];
            if(isset($validatedData['imageUrl'])){
                if($cate -> image_id != null){
                    $oldImageFilename = $cate -> image -> image_url;
                    $oldImagePath = public_path('images/category/') . $oldImageFilename;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $image = Image::find($cate->image_id);
                } else {
                    $image = new Image();
                }
                
                $base64String = $validatedData['imageUrl'];
                $base64Data = substr($base64String, strpos($base64String, ',') + 1);
                $imageData = base64_decode($base64Data);
                $filename = uniqid() . '.png'; 
                $storagePath = public_path('images/category/');
                file_put_contents($storagePath. $filename, $imageData);
                $image->image_url = $filename;
                $image->save();
                $cate -> image_id = $image -> image_id;
            }
            
            $result = $cate -> save();
            if(!$result)
                return response()->json([
                    'result' => false,
                    'message' => 'Updated unsuccessfully !'
                ]);
            return response()->json([
                'result' => True,
                'message' => 'Updated successfully !'
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'result' => false,
                'message' => $e->errors(),
            ], 422);
        }
    }

    public function delete($id){
        if(Category::find($id) == null)
            return response()->json([
                'result' => false,
                'message' => 'Category doesnt exist'
            ]);
        $cate = Category::find($id);
        $products = Product::where('category_id', $id) ->get();
        foreach($products as $product){
            $product -> category_id = null;
            $product -> save();
        }
        $image = Image::find($cate -> image_id);
        $result = Category::destroy($id);
        if($image != null){
            $oldImageFilename = $image -> image_url;
            $oldImagePath = public_path('images/category/') . $oldImageFilename;
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
            $image -> delete();
        }
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => 'Delete successfully !'
            ]);
    
        return response()->json([
            'result' => true,
            'message' => 'Delete successfully !'
        ]);
    }
}