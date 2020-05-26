<?php

namespace App\Model\Setting;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	protected $fillable = ['key', 'value'];

	public $timestamps = false;
}