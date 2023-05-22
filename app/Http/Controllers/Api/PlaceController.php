<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function getProvinces()
    {
        $province = Province::all();

        return response()->json([
            'data' => $province
        ]);
    }

    public function getCities($provinceCode)
    {
        $cities = City::where('province_code', $provinceCode)->get();
        return response()->json([
            'data' => $cities
        ]);
    }

    // public function getVillages($cityCode)
    // {
    //     dd(123);
    //     $villages = Village::where('city_code', $cityCode)->get();
    //     return response()->json([
    //         'data' => $villages
    //     ]);
    // }


}
