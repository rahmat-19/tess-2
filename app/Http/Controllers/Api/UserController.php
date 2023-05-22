<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('role', 'rekenings')->get();

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found!'
            ]);
        }

        return response()->json(['data' => $user], 200);
    }
    
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'kode_referal' => 'required',
            // 'village_id' => 'required|exists:village,id',
            'role_id' => 'required'
        ];

        $customMessages = [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa format yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ];
    
        try {
            $request->validate($rules, $customMessages);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'kode_referal' => $request->kode_referal,
            'village_id' => $request->village_id,
            'role_id' => $request->role_id,
        ]);
        return response()->json([
            'message' => 'User created successfully', 
            'data' => $user
        ], 201);
    }

    public function show($id)
    {
        $user = User::with('role')->find($id);

        if (!$user) {
         return response()->json([
            'message' => 'User Not Found!'
         ], 404);          
        }

        return response()->json([
            'data' => $user
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found!'
            ], 404);
        }
        $rules = [
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|required',
            'kode_referal' => 'sometimes|required',
            'village_id' => 'sometimes|required',
            'role_id' => 'sometimes|required',
        ];
        
        $customMessages = [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email harus berupa format yang valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
        ];
    
        try {
            $request->validate($rules, $customMessages);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    
        $request->validate($rules);
    
        $data = $request->only(array_keys($rules));
    
        if ($request->has('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
        return response()->json([
            'message' => 'User updated successfully', 
            'data' => $user], 
        200);
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User Not Found!'
            ], 404);
        }

        $user->delete();
        return response()->json([
            'message' => 'User Deleted Successfully!'
        ], 201);
    }

}
