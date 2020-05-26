<?php

namespace App\Model;

use App\Model\Property\Property;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $table = "sale_details";

    protected $fillable = [
        "sale_id",
        "property_id",
        "price",
        "note"
    ];

    public $timestamps = false;

    protected $primaryKey = "id";

    public function property()
    {
        return $this->belongsTo(Property::class, "property_id", "id");
    }
}
