<?php

namespace App\Model\Office;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $table = "offices";


	protected $fillable = ["is_main", "province_id", "district_id", "commune_id", "village_id",
        "name", "address", "latitude", "longitude", "phone", "email", "picture", "thumbnail",
        "description", "data"];

	public $timestamps = true;

	public function properties()
    {
        return $this->belongsToMany("App\Model\Property\Property", 'property_office');
    }
}