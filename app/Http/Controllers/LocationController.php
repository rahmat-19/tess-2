<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['index', 'indexSampling']);
    }

    public function userIndex()
    {
        return view('user.index');
    }

    public function index()
    {
        return view('location.index');
    }

    public function find()
    {
        $data = Location::with('facilities')->get();
        return response()->json($data);
    }

    public function show(Location $location)
    {
        return response()->json($location->with('facilities')->first());
    }

    public function indexSampling()
    {
        return view('sampling.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:pdf,xlx,csv,png,jpg|max:2048',
        ]);

        $fileName = time() . '.' . $request->image->extension();

        $location = Location::create([
            'address_name' => $request->address_name,
            'type' => 'tour',
            'description' => $request->description,
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
            'price' => $request->price,
            'open_at' => $request->open_at,
            'close_at' => $request->close_at,
            'image' => $fileName,
        ]);
        if ($location) {
            $request->image->move(public_path('locations'), $fileName);
            return response()->json([
                'data' => $location,
                'status' => 200,
            ]);
        }
        return response()->json([
            'status' => 500
        ]);
    }

    public function storeSampling(Request $request)
    {
        $location = Location::create([
            'address_name' => $request->address_name,
            'type' => 'path',
            'longitude' => $request->longitude,
            'latitude' => $request->latitude,
        ]);
        if ($location) {
            return response()->json([
                'data' => $location,
                'status' => 200,
            ]);
        }
        return response()->json([
            'status' => 500
        ]);
    }

    public function destroy($id)
    {
        $location = Location::find($id);
        if ($location->delete()) {
            return response()->json([
                'message' => 'success delted',
                'status' => 200,
            ]);
        }
        return response()->json([
            'status' => 500
        ]);
    }
}
