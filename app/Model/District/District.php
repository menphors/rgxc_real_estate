<?php

namespace App\Model\District;

use App\Model\Province\Province;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class District extends Model
{
    use Translatable;

    protected $table = 'districts';

    public $translatedAttributes = ["title"];

    protected $fillable = ['code', "province_id"];

    public function province()
    {
        return $this->belongsTo(Province::class, "province_id", "id");
    }

}

class DistrictTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ["district_id", "locale", 'title'];
}