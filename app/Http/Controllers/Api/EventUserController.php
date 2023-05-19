<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EventUser;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EventUserController extends Controller
{
    public function index()
    {
        $eventUsers = EventUser::all();

        if ($eventUsers) {
            return response()->json([
                'data' => $eventUsers
            ], 200);
        }
        return response()->json([
            'message' => 'Event User Not Found'
        ], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'user_id' => 'required',
            'nama' => 'required|string',
            'tanggal' => 'required',
            'deskripsi' => 'required|string',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $eventUser = EventUser::create([
            'user_id' => $request->user_id,
            'nama' => $request->nama,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
        ]);

        return response()->json([
            'message' => 'Event User Created Successfully!',
            'data' => $eventUser
        ], 201);
    }

    public function show($id)
    {
        $eventUser = EventUser::find($id);

        if ($eventUser) {
            return response()->json([
                'data' => $eventUser
            ], 200);
        }
        return response()->json([
            'message' => 'Event User Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $eventUser = EventUser::find($id);

        if (!$eventUser) {
            return response()->json([
                'message' => 'Event User Not Found!'
            ], 404);
        }

        $rules = [
            'user_id' => 'sometimes|required',
            'nama' => 'sometimes|required|string',
            'tanggal' => 'sometimes|required',
            'deskripsi' => 'sometimes|required',
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

        $eventUser->update($data);

        return response()->json([
            'message' => 'Event User Updated Successfully!',
            'data' => $eventUser
        ], 201);
    }

    public function delete($id)
    {
        $eventUser = EventUser::find($id);

        if ($eventUser) {
            $eventUser->delete();
            return response()->json([
                'message' => 'Event User Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Event User Not Found!'
        ], 404);
    }
}
