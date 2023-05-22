<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;

class RolePermissionController extends Controller
{
    public function index()
    {
        // $userPermission = User::with('permissions')->get();
        $rolePermission = RolePermission::all();

        return response()->json([
            'data' => $rolePermission
        ], 200);
    }

    public function assignPermission(Request $request, $roleId)
    {
        $permissionIds = $request->permissionIds;

        $role = Role::findOrFail($roleId);

        $permissions = Permission::whereIn('id', $permissionIds)->get();

        if (!$role) {
            return response()->json([
                'message' => 'Role Not Found!'
            ], 404);
        }

        $role->permissions()->sync($permissions);

        return response()->json([
            'message' => 'Permission Assigned Successfully'
        ], 201);
    }
}
