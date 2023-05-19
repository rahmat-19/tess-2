<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RekeningController extends Controller
{
    public function index()
    {
        $rekening = Rekening::all();

        if ($rekening) {
            return response()->json([
                'data' => $rekening
            ], 200);
        }
        return response()->json([
            'message' => 'Rekening Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'kode' => 'required',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $rekening = Rekening::create([
            'name' => $request->name,
            'kode' => $request->kode,
        ]);

        return response()->json([
            'message' => 'Rekening Created Successfully!',
            'data' => $rekening
        ], 201);
    }

    public function show($id)
    {
        $rekening = Rekening::find($id);

        if ($rekening) {
            return response()->json([
                'data' => $rekening
            ], 200);
        }
        return response()->json([
            'message' => 'Rekening Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $rekening = Rekening::find($id);

        if (!$rekening) {
            return response()->json([
                'message' => 'Rekening Not Found!'
            ], 404);
        }

        $rules = [
            'name' => 'sometimes|required',
            'kode' => 'sometimes|required',
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

        $rekening->update($data);

        return response()->json([
            'message' => 'Rekening Updated Successfully!',
            'data' => $rekening
        ], 201);
    }

    public function delete($id)
    {
        $rekening = rekening::find($id);

        if ($rekening) {
            $rekening->delete();
            return response()->json([
                'message' => 'Rekening Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Rekening Not Found!'
        ], 404);
    }
}
