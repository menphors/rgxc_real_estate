<?php

namespace App\Http\Controllers\Admin;

use App\Model\Commune\Commune;
use App\Model\Commune\CommuneTranslation;
use App\Model\District\District;
use App\Model\District\DistrictTranslation;
use App\Model\Province\Province;
use App\Model\Province\ProvinceTranslation;
use App\Model\Village\Village;
use App\Model\Village\VillageTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function province()
    {
        $provinces_bak = DB::table('provinces_bak')->get();

        foreach($provinces_bak as $province){
            $save = Province::create([
                "code" => $province->code,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            ProvinceTranslation::create([
                "province_id" => $save->id,
                "locale" => "kh",
                "title" => $province->name_kh,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            ProvinceTranslation::create([
                "province_id" => $save->id,
                "locale" => "en",
                "title" => $province->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);

            ProvinceTranslation::create([
                "province_id" => $province->id,
                "locale" => "cn",
                "title" => $province->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        die("success");
    }

    public function district()
    {
        $bak = DB::table('districts_bak')->get();

        foreach($bak as $value){
            $save = District::create([
                "province_id" => $value->province_id,
                "code" => $value->code,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            DistrictTranslation::create([
                "district_id" => $save->id,
                "locale" => "kh",
                "title" => $value->name_kh,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            DistrictTranslation::create([
                "district_id" => $save->id,
                "locale" => "en",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);

            DistrictTranslation::create([
                "district_id" => $value->id,
                "locale" => "cn",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        die("success");
    }

    public function commune()
    {
        $bak = DB::table('communes_bak')->get();

        foreach($bak as $value){
            $save = Commune::create([
                "district_id" => $value->district_id,
                "code" => $value->code,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            CommuneTranslation::create([
                "commune_id" => $save->id,
                "locale" => "kh",
                "title" => $value->name_kh,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            CommuneTranslation::create([
                "commune_id" => $save->id,
                "locale" => "en",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);

            CommuneTranslation::create([
                "commune_id" => $value->id,
                "locale" => "cn",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        die("success");
    }

    public function village()
    {
        set_time_limit(3000);
        $bak = DB::table('villages_bak')->get();

        foreach($bak as $value){
            $save = Village::create([
                "commune_id" => $value->commune_id,
                "code" => $value->code,
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            VillageTranslation::create([
                "village_id" => $save->id,
                "locale" => "kh",
                "title" => $value->name_kh,
                "created_at" => now(),
                "updated_at" => now()
            ]);
            VillageTranslation::create([
                "village_id" => $save->id,
                "locale" => "en",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);

            VillageTranslation::create([
                "village_id" => $value->id,
                "locale" => "cn",
                "title" => $value->name,
                "created_at" => now(),
                "updated_at" => now()
            ]);
        }

        die("success");
    }
}
