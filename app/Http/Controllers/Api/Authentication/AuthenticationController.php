<?php

namespace App\Http\Controllers\Api\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            // 'kode_referal' => 'required',
            // 'village_id' => 'required|exists:village,id',
            // 'role_id' => 'required',
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

        $lastUser = User::orderBy('id', 'desc')->first();
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['role_id'] = 3;
        $input['kode_referal'] = $lastUser->kode_referal + 1;
        $user = User::create($input);

        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'success' => true,
            'message' => 'Registered Successfully!',
            'data' => $success
        ]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $auth = Auth::user();
            $success['token'] = $auth->createToken('auth_token')->plainTextToken;
            $success['name'] = $auth->name;
            $success['email'] = $auth->email;
            $success['id'] = $auth->id;
            $success['role'] = $auth->role->name;

            return response()->json([
                'success' => true,
                'message' => 'Login Success',
                'data' => $success
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials'
            ]);
        }
    }

    public function profile(Request $request)
    {
        if ($request->user()) {
            return response()->json([
                'data' => $request->user()->load('role')
            ]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
