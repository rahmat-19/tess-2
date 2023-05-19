<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    public function index()
    {
        $permission = Permission::all();

        if ($permission) {
            return response()->json([
                'data' => $permission
            ], 200);
        }
        return response()->json([
            'message' => 'Permission Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $permission = Permission::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'Permission Created Successfully!',
            'data' => $permission
        ], 201);
    }

    public function show($id)
    {
        $permission = Permission::find($id);

        if ($permission) {
            return response()->json([
                'data' => $permission
            ], 200);
        }
        return response()->json([
            'message' => 'Permission Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);

        if (!$permission) {
            return response()->json([
                'message' => 'Permission Not Found!'
            ], 404);
        }

        $rules = [
            'name' => 'sometimes|required|string',
            'description' => 'sometimes|required',
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

        $permission->update($data);

        return response()->json([
            'message' => 'Permission Updated Successfully!',
            'data' => $permission
        ], 201);
    }

    public function delete($id)
    {
        $permission = Permission::find($id);

        if ($permission) {
            $permission->delete();
            return response()->json([
                'message' => 'Permission Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Permission Not Found!'
        ], 404);
    }
}
