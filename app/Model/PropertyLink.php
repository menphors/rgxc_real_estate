<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyLink extends Model
{
    protected $table = "property_link";

    protected $fillable =["agent_id", "property_id", "token", "valid_from", "valid_to", "created_by", "data"];

    public $timestamps = true;
}
