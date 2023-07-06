<?php

namespace App\Http\Controllers;

use App\Models\ProductShape;
use Illuminate\Http\Request;
use App\Models\Product;
class BEProductShapeController extends Controller
{
    public function index(){
        $shapes = ProductShape::all();
        if($shapes -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($shapes as $shape){
            $shapeData[] = [
                'productShapeId' => $shape->product_shape_id,
                'shapeName' => $shape->shape_name,
            ];
        }
        return response()->json($shapeData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'shapeName' => 'required|unique:product_shape,shape_name',
        ]);
        $result = new ProductShape();
        $result -> shape_name = $validatedData['shapeName'];
        $check = $result -> save();
        if(!$check)
            return response()->json([
                'result' => false,
                'message' => "Created shape unsuccessfully!",
            ]);
        
        return response()->json($result);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'shapeName' => 'required|unique:product_shape,shape_name,'. $id . ',product_shape_id'
        ]);

        $result = ProductShape::find($id);
        if($result == null)
            return response()->json([
                'result' => false,
                'message' => "Shape doesn't exist!",
            ]);
        
        $result -> shape_name = $validatedData['shapeName'];
        $result -> save();
        return response()->json([
            'result' => true,
            'message' => "Updated shape successfully!",
        ]);
    }

    public function delete($id){
        if(ProductShape::find($id) == null)
            return response()->json([
                'result' => false,
                'message' => "Shape doesn't exist!",
            ]);
        $products = Product::where('product_shape_id', $id) ->get();
        foreach($products as $product){
            $product -> product_shape_id = null;
            $product -> save();
        }
        $result = ProductShape::destroy($id);
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => "Deleted shape unsuccessfully!",
            ]);
    
        return response()->json([
            'result' => true,
            'message' => "Deleted shape successfully!",
        ]);
    }
}