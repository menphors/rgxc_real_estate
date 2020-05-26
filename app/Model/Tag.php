<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use App\Model\Property\Property;

class Tag extends Model
{
    use Translatable;

    protected $table = 'tags';

    public $translatedAttributes = ["title"];

    protected $primaryKey = "id";
}

class TagTranslation extends Model
{
    protected $table = "tag_translates";

    public $timestamps = false;

    protected $fillable = ["tag_id", "locale", 'title'];
}
