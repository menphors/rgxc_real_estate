<?php

namespace App\Model;

use App\Model\Staff\Staff;
use Illuminate\Database\Eloquent\Model;

class PropertyHasStaff extends Model
{
    protected $table = "property_staff";

    protected $fillable =["property_id", "staff_id", "type"];

    public $timestamps = false;

    public function staff_id()
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }
}
