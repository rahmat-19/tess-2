<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserPermission;

class UserPermissionController extends Controller
{
    public function index()
    {
        // $userPermission = User::with('permissions')->get();
        $userPermission = UserPermission::all();

        return response()->json([
            'data' => $userPermission
        ], 200);
    }

    public function assignPermission(Request $request, $userId)
    {
        $permissionIds = $request->permissionIds;

        $user = User::find($userId);

        $permissions = Permission::whereIn('id', $permissionIds)->get();

        $user->permissions()->sync($permissions);

        return response()->json([
            'message' => 'Permission Assigned Successfully'
        ], 201);
    }
}
