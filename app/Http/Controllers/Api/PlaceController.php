<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Province;
use App\Models\Village;
use App\Models\District;

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

    public function getVillages($cityCode)
    {
        $districts = District::where('city_code', $cityCode)->pluck('code');
        $villages = Village::whereIn('district_code', $districts)->get();
        
        return response()->json([
            'data' => $villages
        ]);
    }


}
