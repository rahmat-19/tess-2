<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{

    public function index()
    {
        // $userRole = User::with('roles')->get();
        $userRole = UserRole::all();

        return response()->json([
            'data' => $userRole
        ], 200);
    }

    public function assignRole(Request $request, $userId)
    {
        $roleIds = $request->roleIds;

        $user = User::findOrFail($userId);

        $roles = Role::whereIn('id', $roleIds)->get();

        $user->roles()->sync($roles);

        return response()->json([
            'message' => 'Role Assigned Successfully!',
        ], 201);        
    }

}
