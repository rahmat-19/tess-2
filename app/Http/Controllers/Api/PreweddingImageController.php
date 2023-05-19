<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreweddingImage;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PreweddingImageController extends Controller
{
    public function index()
    {
        $preweddingImages = PreweddingImage::all();

        if ($preweddingImages) {
            return response()->json([
                'data' => $preweddingImages
            ], 200);
        }
        return response()->json([
            'message' => 'Prewedding Images Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'image' => 'required|string',
            'name' => 'required|string',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $preweddingImage = PreweddingImage::create([
            'user_id' => $request->user_id,
            'image' => $request->image,
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Prewedding Image Created Successfully!',
            'data' => $preweddingImage
        ], 201);
    }

    public function show($id)
    {
        $preweddingImage = PreweddingImage::find($id);

        if ($preweddingImage) {
            return response()->json([
                'data' => $preweddingImage
            ], 200);
        }
        return response()->json([
            'message' => 'Prewedding Image Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $preweddingImage = PreweddingImage::find($id);

        if (!$preweddingImage) {
            return response()->json([
                'message' => 'Prewedding Image Not Found!'
            ], 404);
        }

        $rules = [
            'user_id' => 'sometimes|required',
            'image' => 'sometimes|required|string',
            'name' => 'sometimes|required|string',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    
        $request->validate($rules);

        $data = $request->only(array_keys($rules));

        $preweddingImage->update($data);

        return response()->json([
            'message' => 'Prewedding Image Updated Successfully!',
            'data' => $preweddingImage
        ], 201);
    }

    public function delete($id)
    {
        $preweddingImage = PreweddingImage::find($id);

        if ($preweddingImage) {
            $preweddingImage->delete();
            return response()->json([
                'message' => 'Prewedding Image Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Prewedding Image Not Found!'
        ], 404);
    }
}
