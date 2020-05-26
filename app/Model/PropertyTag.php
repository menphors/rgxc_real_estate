<?php

namespace App\Model;

use App\Model\Tag;
use Illuminate\Database\Eloquent\Model;

class PropertyTag extends Model
{
    protected $table = "property_tag";

    protected $fillable =["property_id", "tag_id", "type"];

    public $timestamps = false;

    public function tag()
    {
        return $this->belongsTo(Tag::class, "tag_id", "id");
    }
}
