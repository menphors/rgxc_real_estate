<?php

namespace App\Model\Village;

use App\Model\Commune\Commune;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Village extends Model
{
    use Translatable;

    protected $table = 'villages';

    public $translatedAttributes = ["title"];

    protected $fillable = ['code', "commune_id"];

    public function commune()
    {
        return $this->belongsTo(Commune::class, "commune_id", "id");
    }

}

class VillageTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ["village_id", "locale", 'title'];
}