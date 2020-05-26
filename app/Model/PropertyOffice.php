<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyOffice extends Model
{
    protected $table = "property_office";

    protected $fillable =["property_id", "office_id"];

    public $timestamps = true;
}
