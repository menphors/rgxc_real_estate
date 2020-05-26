<?php

namespace App\Model\Contract;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
	protected $fillable = [
							'staff_id', 
							'property_id', 
							'customer_id', 
							'type', 
							'create_on', 
							'start_date', 
							'end_date', 
							'commission', 
							'amount', 
							'data', 
							'created_by', 
							'updated_by',
							'user_id'
						];

	public function customer() {

	}

	public function user() {

	}

	public function staff() {
		
	}

}