<?php

namespace App\Model\Owner;

use App\Model\Commune\Commune;
use App\Model\District\District;
use App\Model\Province\Province;
use App\Model\Village\Village;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
	protected $table = "owner";

    protected $fillable =[
        "province_id",
        "district_id",
        "commune_id",
        "village_id",
        "name",
        "phone",
        "phone2",
        "phone3",
        "email",
        "address",
        "thumbnail",
        "remark",
        "gender",
        "id_card",
        "home_number"
    ];

    protected $primaryKey ="id";

    public $timestamps = true;

    public function province_id()
    {
        return $this->belongsTo(Province::class, "province_id", "id");
    }

    public function district_id()
    {
        return $this->belongsTo(District::class, "district_id", "id");
    }

    public function commune_id()
    {
        return $this->belongsTo(Commune::class, "commune_id", "id");
    }

    public function village_id()
    {
        return $this->belongsTo(Village::class, "village_id", "id");
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}