<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PropertyHasOwner extends Model
{
    protected $table = "property_has_owner";

    protected $fillable = ["property_id", "owner_id"];

    public $timestamps = false;

    public function owner_id()
    {
        return $this->belongsTo(Owner::class, "owner_id", "id");
    }
}
