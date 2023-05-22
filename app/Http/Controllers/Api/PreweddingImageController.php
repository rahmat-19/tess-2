<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PreweddingImage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PreweddingImageController extends Controller
{
    public function index()
    {
        $userId = auth()->user()->id;
        $preweddingImages = PreweddingImage::where('user_id', $userId)->get();

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
        $userId = auth()->user()->id;
        $rules = [
            'image' => 'required',
            // 'name' => 'required|string',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->storeAs('prewedding_images', $imageName);

        $preweddingImageCreate = [
            'user_id' => $userId,
            'image' => $imageName,
            'name' => $imageName,
            'url' => url("uploads/prewedding_images/$imageName"),
        ];
        $preweddingImage = PreweddingImage::create($preweddingImageCreate);

        return response()->json([
            'message' => 'Prewedding Image Created Successfully!',
            'data' => $preweddingImage
        ], 201);
    }

    public function show($id)
    {
        $userId = auth()->user()->id;
        $preweddingImageByUser = PreweddingImage::where('user_id', $userId)->get();
        $preweddingImage = $preweddingImageByUser->find($id);

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
        $userId = auth()->user()->id;
        $preweddingImageByUser = PreweddingImage::where('user_id', $userId)->get();
        $preweddingImage = $preweddingImageByUser->find($id);
        // $preweddingImage = PreweddingImage::find($id);

        if (!$preweddingImage) {
            return response()->json([
                'message' => 'Prewedding Image Not Found!'
            ], 404);
        }

        $rules = [
            'image' => 'sometimes|required|string',
            'name' => 'sometimes|required|string',
            'url' => 'sometimes|required|string',
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
            unlink('uploads/prewedding_images' . '/' . $preweddingImage->image);
            $preweddingImage->delete();
            return response()->json([
                'message' => 'Prewedding Image Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Prewedding Image Not Found!'
        ], 404);
    }

    public function storeMany(Request $request)
    {
        $userId = auth()->user()->id;
        $rules = [
            'images.*' => 'required',
            'names.*' => 'required|string',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }


        $preweddingImages = [];

        foreach ($request->images as $index => $image) {
            $imageName = time() . '_' . $index . '.' . $image->extension();
            $image->storeAs('prewedding_images', $imageName);

            $preweddingImageCreate = [
                'user_id' => $userId,
                'image' => $imageName,
                'name' => $imageName,
                'url' => "/uploads/prewedding_images/$imageName"
            ];

            $preweddingImages[] = PreweddingImage::create($preweddingImageCreate);
        }


        return response()->json([
            'message' => 'Prewedding Image Created Successfully!',
            'data' => $preweddingImages
        ], 201);
    }

    public function deleteMany(Request $request)
    {
        foreach ($request->ids as $id) {
            $preweddingImage = PreweddingImage::where('id', $id)->get();
            unlink('uploads/prewedding_images' . '/' . $preweddingImage[0]->image);
            PreweddingImage::where('id', $id)->delete();
        }

        return response()->json([
            'message' => 'Prewedding Images Deleted Successfully!'
        ]);
    }
}
