<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubdomainController extends Controller
{
    public function index()
    {
    $subdomain = Subdomain::with('user')->get();

        if ($subdomain) {
            return response()->json([
                'data' => $subdomain
            ], 200);
        }
        return response()->json([
            'message' => 'Subdomain Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'tanggal_aktif' => 'required',
            'user_id' => 'required'
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $subdomain = Subdomain::create([
            'name' => $request->name,
            'tanggal_aktif' => $request->tanggal_aktif,
            'user_id' => $request->user_id,
        ]);

        return response()->json([
            'message' => 'Subdomain Created Successfully!',
            'data' => $subdomain
        ], 201);
    }

    public function show($id)
    {
        $subdomain = Subdomain::find($id);

        if ($subdomain) {
            return response()->json([
                'data' => $subdomain
            ], 200);
        }
        return response()->json([
            'message' => 'Subdomain Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $subdomain = Subdomain::find($id);

        if (!$subdomain) {
            return response()->json([
                'message' => 'Subdomain Not Found!'
            ], 404);
        }

        $rules = [
            'name' => 'sometimes|required|string',
            'tanggal_aktif' => 'sometimes|required',
            'user_id' => 'sometimes|required',
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

        $subdomain->update($data);

        return response()->json([
            'message' => 'Subdomain Updated Successfully!',
            'data' => $subdomain
        ], 201);
    }

    public function delete($id)
    {
        $subdomain = Subdomain::find($id);

        if ($subdomain) {
            $subdomain->delete();
            return response()->json([
                'message' => 'Subdomain Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Subdomain Not Found!'
        ], 404);
    }
}
