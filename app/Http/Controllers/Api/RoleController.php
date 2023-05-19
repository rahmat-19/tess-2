<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        if ($role) {
            return response()->json([
                'data' => $role
            ], 200);
        }
        return response()->json([
            'message' => 'Role Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $role = Role::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'message' => 'Role Created Successfully!',
            'data' => $role
        ], 201);
    }

    public function show($id)
    {
        $role = Role::find($id);

        if ($role) {
            return response()->json([
                'data' => $role
            ], 200);
        }
        return response()->json([
            'message' => 'Role Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            return response()->json([
                'message' => 'Role Not Found!'
            ], 404);
        }

        $rules = [
            'name' => 'sometimes|required',
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

        $role->update($data);

        return response()->json([
            'message' => 'Role Updated Successfully!',
            'data' => $role
        ], 201);
    }

    public function delete($id)
    {
        $role = Role::find($id);

        if ($role) {
            $role->delete();
            return response()->json([
                'message' => 'Role Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Role Not Found!'
        ], 404);
    }
}
