<?php

namespace App\Http\Controllers;

use App\Models\ProductStyle;
use Illuminate\Http\Request;

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
        $result -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');

        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'styleName' => 'required|unique:product_style,style_name,'. $id . ',product_style_id'
        ]);

        $result = ProductStyle::find($id);
        $result -> style_name = $validatedData['styleName'];
        $result -> save();
        if(!$result)
            return response()->json('Updated unsuccessfully !');

        return response()->json('Updated successfully !', 201);
    }

    public function delete($id){
        if(ProductStyle::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $result = ProductStyle::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');

        return response()->json('Deleted successfully !', 201);
    }
}
