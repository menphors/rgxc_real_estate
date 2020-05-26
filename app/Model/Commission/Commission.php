<?php

namespace App\Model\Commission;

use App\Model\Staff\Staff;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
	protected $fillable = ['property_id', 'commission', 'to', 'type'];

	public $timestamps = false;

}