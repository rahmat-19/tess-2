<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Rekening;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\RekeningUser;

class RekeningUserController extends Controller
{
    public function index()
    {
        $rekeningUser = RekeningUser::all();

        return response()->json([
            'data' => $rekeningUser
        ], 200);
    }

    public function addRekening(Request $request, $userId)
    {
        $rekeningIds = $request->rekeningIds;

        $user = User::find($userId);

        $rekenings = Rekening::whereIn('id', $rekeningIds)->get();

        $user->rekenings()->sync($rekenings);

        return response()->json([
            'message' => 'Rekening added Successfully'
        ], 201);
    }
}
