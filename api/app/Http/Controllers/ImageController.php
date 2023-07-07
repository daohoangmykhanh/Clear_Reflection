<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        $imageData = [];

        foreach ($images as $image) {
            $imageData[] = [
                'image_id' => $image->image_id,
                'image_url' => $image->image_url,
            ];
        }

        return response()->json([
            'images' => $imageData,
        ]);
    }

    public function show($id)
    {
        $image = Image::findOrFail($id);

        return response()->json([
            'image' => [
                'image_id' => $image->image_id,
                'image_url' => $image->image_url,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image_url' => 'required|string',
        ]);

        $image = Image::create($validatedData);

        return response()->json([
            'image' => [
                'image_id' => $image->image_id,
                'image_url' => $image->image_url,
            ],
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'image_url' => 'required|string',
        ]);

        $image = Image::findOrFail($id);
        $updated = $image->update($validatedData);

        if ($updated) {
            return response()->json([
                'result' => true,
                'message' => 'Image updated successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to update image.',
            ]);
        }
    }

    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $deleted = $image->delete();

        if ($deleted) {
            return response()->json([
                'result' => true,
                'message' => 'Image deleted successfully.',
            ]);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Failed to delete image.',
            ]);
        }
    }
}
