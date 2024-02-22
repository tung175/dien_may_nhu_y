<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use HoangPhi\VietnamMap\Models\Province;
use HoangPhi\VietnamMap\Models\District;
use HoangPhi\VietnamMap\Models\Ward;

class LocationController extends Controller
{
    public function getProvinces() {
        $provinces = Province::all();
        return response()->json($provinces);
    }

    public function getDistricts(Request $request) {
        $districts = District::where('province_id', $request->province_id)->get();
        return response()->json($districts);
    }

    public function getWards(Request $request) {
        $wards = Ward::where('district_id', $request->district_id)->get();
        return response()->json($wards);
    }
}
