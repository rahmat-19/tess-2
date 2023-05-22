<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Greeting;
use App\Models\Subdomain;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GreetingController extends Controller
{
    public function index()
    {
        $greeting = Greeting::with('subdomain')->get();

        if ($greeting) {
            return response()->json([
                'data' => $greeting
            ], 200);
        }
        return response()->json([
            'message' => 'Greeting Not Found'
        ], 404);
    }

    public function store(Request $request)
    {

        $subdomain = Subdomain::find($request->domain_id);

        if (!$subdomain) {
            return response()->json([
                'message' => 'Subdomain Not Found!'
            ], 404);
        }

        $rules = [
            'domain_id' => 'required',
            'name_guest' => 'required',
            'greeting_word' => 'required',
            'kehadiran' => 'required',
        ];

        try {
            $request->validate($rules);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }

        $greeting = Greeting::create([
            'domain_id' => $request->domain_id,
            'name_guest' => $request->name_guest,
            'greeting_word' => $request->greeting_word,
            'kehadiran' => $request->kehadiran,
        ]);

        return response()->json([
            'message' => 'Greeting Created Successfully!',
            'data' => $greeting
        ], 201);
    }

    public function show($id)
    {
        $greeting = Greeting::with('subdomain')->find($id);

        if ($greeting) {
            return response()->json([
                'data' => $greeting
            ], 200);
        }
        return response()->json([
            'message' => 'Greeting Not Found!'
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $greeting = Greeting::find($id);

        if (!$greeting) {
            return response()->json([
                'message' => 'Greeting Not Found!'
            ], 404);
        }

        $rules = [
            'domain_id' => 'sometimes|required',
            'name_guest' => 'sometimes|required',
            'greeting_word' => 'sometimes|required',
            'kehadiran' => 'sometimes|required',
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

        $greeting->update($data);

        return response()->json([
            'message' => 'Greeting Updated Successfully!',
            'data' => $greeting
        ], 201);
    }

    public function delete($id)
    {
        $greeting = Greeting::find($id);

        if ($greeting) {
            $greeting->delete();
            return response()->json([
                'message' => 'Greeting Deleted Successfully!',
            ], 201);
        }

        return response()->json([
            'message' => 'Greeting Not Found!'
        ], 404);
    }

    public function deleteMany(Request $request)
    {
        foreach ($request->ids as $id) {
            Greeting::where('id', $id)->delete();
        }

        return response()->json([
            'message' => 'Greetings Deleted Successfully!'
        ]);
    }
}
