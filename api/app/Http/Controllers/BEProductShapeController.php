<?php

namespace App\Http\Controllers;

use App\Models\ProductShape;
use Illuminate\Http\Request;

class BEProductShapeController extends Controller
{
    public function index(){
        $shapes = ProductShape::all();
        if($shapes -> isEmpty()){
            return response()->json([
                'result' => false,
                'message' => "No results found!",
            ]);
        }
        foreach($shapes as $shape){
            $shapeData[] = [
                'productStyleId' => $shape->product_shape_id,
                'styleName' => $shape->shape_name,
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
        $result -> save();
        if(!$result)
            return response()->json('Created unsuccessfully !');

        return response()->json('Created successfully !', 201);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'shapeName' => 'required|unique:product_shape,shape_name,'. $id . ',product_shape_id'
        ]);

        $result = ProductShape::find($id);
        if(!$result)
            return response()->json('Shape not found! ');

        $result -> shape_name = $validatedData['shapeName'];
        $result -> save();
        return response()->json('Updated successfully !', 201);
    }

    public function delete($id){
        if(ProductShape::find($id) == null)
            return response()->json('Id doesn`t exist !');
        $result = ProductShape::destroy($id);
        if(!$result)
            return response()->json('Deleted unsuccessfully !');

        return response()->json('Deleted successfully !', 201);
    }
}
