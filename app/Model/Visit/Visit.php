<?php

namespace App\Model\Visit;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
	protected $fillable = ['customer_id', 'staff_id', 'property_id', 'user_id', 'created_by', 'updated_by', 'feedback'];
}