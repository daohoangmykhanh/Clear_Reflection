<?php

namespace App\Http\Controllers;

use App\Models\ProductStyle;
use Illuminate\Http\Request;
use App\Models\Product;
class BEProductStyleController extends Controller
{
    public function index(){
        $styles = ProductStyle::all();
        if($styles -> isEmpty()){
            return response()->json('No results found!');
        }
        foreach($styles as $style){
            $styleData[] = [
                'productStyleId' => $style->product_style_id,
                'styleName' => $style->style_name,
            ];
        }
        return response()->json($styleData);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'styleName' => 'required|unique:product_style,style_name',
        ]);
        $result = new ProductStyle();
        $result -> style_name = $validatedData['styleName'];
        $check = $result -> save();
        if(!$check)
            return response()->json('Created unsuccessfully !');

        return response()->json($result);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'styleName' => 'required|unique:product_style,style_name,'. $id . ',product_style_id'
        ]);

        $result = ProductStyle::find($id);
        if($result == null)
            return response()->json([
                'result' => false,
                'message' => "Style unsuccessfully!",
            ]);
        $result -> style_name = $validatedData['styleName'];
        $result -> save();

        return response()->json([
            'result' => true,
            'message' => "Updated style successfully!",
        ]);
    }

    public function delete($id){
        if(ProductStyle::find($id) == null)
            return response()->json([
                'result' => false,
                'message' => "Style doesn't exist!",
            ]);
        $products = Product::where('product_style_id', $id) ->get();
        foreach($products as $product){
            $product -> product_styl_id = null;
            $product -> save();
        }
        $result = ProductStyle::destroy($id);
        if(!$result)
            return response()->json([
                'result' => false,
                'message' => "Deleted style unsuccessfully!",
            ]);

        return response()->json([
            'result' => true,
            'message' => "Deleted style successfully!",
        ]);
    }
}
