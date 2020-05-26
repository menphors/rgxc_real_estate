<?php

namespace App\Model;

use App\Model\Property\Property;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = "projects";

    protected $fillable =["title", "thumbnail", "latitude", "longitude", "description"];

    public $timestamps = true;

    public function properties()
    {
        return $this->hasMany(Property::class, "project_id", "id");
    }
}
