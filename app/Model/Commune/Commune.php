<?php

namespace App\Model\Commune;

use App\Model\District\District;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Commune extends Model
{
    use Translatable;

    protected $table = 'communes';

    public $translatedAttributes = ["title"];

    protected $fillable = ['code', "district_id"];

    public function district()
    {
        return $this->belongsTo(District::class, "district_id", "id");
    }

}

class CommuneTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ["commune_id", "locale", 'title'];
}