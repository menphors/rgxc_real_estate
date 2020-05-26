<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Model\Property\Property;

class PropertyType extends Model
{
    use Translatable;

    protected $table = 'property_types';

    public $translatedAttributes = ["title"];

    protected $primaryKey = "id";

    public function properties()
    {
        return $this->hasMany(Property::class, "property_type_id", "id");
    }

}

class PropertyTypeTranslation extends Model
{
    protected $table = "property_type_translates";

    public $timestamps = false;

    protected $fillable = ["property_type_id", "locale", 'title'];
}
