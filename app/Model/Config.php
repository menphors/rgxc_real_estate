<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $table = "config";

    protected $fillable =["id", "data"];

    public $timestamps = true;
}
