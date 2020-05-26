<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Province\Province;

class ProccessController extends Controller
{
    public function getDistrictByProvinceID($province_id){
        $districts = Province::with('provinceDistrict')->where('id', $province_id)->first();
        return response()->json($districts->provinceDistrict);
    }
}
