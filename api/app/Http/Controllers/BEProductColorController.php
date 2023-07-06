<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;
use App\Models\ProductVariant;

class BEProductColorController extends Controller
{
    public function index(){
        $colors = ProductColor::all();
        if($colors -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($colors as $color){
            $colorData[] = [
                'productColorId' => $color->product_color_id,
                'colorName' => $color->color_name,
            ];
        }
        return response()->json($colorData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'colorName' => 'required|unique:product_color,color_name',
        ]);
        $result = new ProductColor();
        $result -> color_name = $validatedData['colorName'];
        $check = $result -> save();
        if(!$check)
            return response()->json([
                'result' => false,
                'message' => "Created color unsuccessfully!",
            ]);
        
        return response()->json($result);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'colorName' => 'required|unique:product_color,color_name,'. $id . ',product_color_id'
        ]);

        $result = ProductColor::find($id);
        if($result == null)
            return response()->json([
                'result' => false,
                'message' => "Color doesn't exist!",
            ]);
        
        $result -> color_name = $validatedData['colorName'];
        $result -> save();
        return response()->json([
            'result' => true,
            'message' => "Updated color successfully!",
        ]);
    }

    public function delete($id){
        if(ProductColor::find($id) == null)
            return response()->json([
                'result' => false,
                'message' => "Color doesn't exist!",
            ]);
        $products = ProductVariant::where('color_id', $id) ->get();
        foreach($products as $product){
            $product -> color_id = null;
            $product -> save();
        }
        $result = ProductColor::destroy($id);
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => "Deleted color unsuccessfully!",
            ]);
    
        return response()->json([
            'result' => true,
            'message' => "Deleted color successfully!",
        ]);
    }
}