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

        $userId = auth()->user()->id;

        // $eventUsers = EventUser::all();
        $eventUsers = EventUser::where('user_id', $userId)->get();

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

        $userId = auth()->user()->id;

        $eventUser = EventUser::create([
            'user_id' => $userId,
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
        $userId = auth()->user()->id;
        $eventByUser = EventUser::where('user_id', $userId)->get();
        $eventUser = $eventByUser->find($id);

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
        $userId = auth()->user()->id;
        $eventByUser = EventUser::where('user_id', $userId)->get();
        $eventUser = $eventByUser->find($id);

        if (!$eventUser) {
            return response()->json([
                'message' => 'Event User Not Found!'
            ], 404);
        }

        $rules = [
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

    public function deleteMany(Request $request)
    {
        foreach ($request->ids as $id) {
            EventUser::where('id', $id)->delete();
        }
        return response()->json([
            'message' => 'Event Users Deleted Successfully!'
        ]);
    }
}
