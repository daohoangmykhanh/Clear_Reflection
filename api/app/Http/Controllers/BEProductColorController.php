<?php

namespace App\Http\Controllers;

use App\Models\ProductColor;
use Illuminate\Http\Request;

class BEProductColorController extends Controller
{
    public function index(){
        $colors = ProductColor::all();
        if($colors -> isEmpty()){
            return response()->json([
                'result' => false,
                'message' => "No results found!",
            ]);
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
        $result -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');

        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'colorName' => 'required|unique:product_color,color_name,'. $id . ',product_color_id'
        ]);

        $result = ProductColor::find($id);
        if(!$result)
            return response()->json('Color not found! ');

        $result -> color_name = $validatedData['colorName'];
        $result -> save();
        return response()->json('Updated successfully !', 201);
    }

    public function delete($id){
        if(ProductColor::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $result = ProductColor::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');

        return response()->json('Deleted successfully !', 201);
    }
}
