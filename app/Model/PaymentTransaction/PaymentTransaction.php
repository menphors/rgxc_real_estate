<?php

namespace App\Model\PaymentTransaction;

use App\Model\Staff\Staff;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $table = "payment_transactions";

	protected $fillable = [
	    'contract_id',
        'sale_id',
        'amount',
        'updated_by',
        'created_by',
        'user_id',
        'description',
        'staff_id',
        'to_type',
        'type'
    ];

	public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, "staff_id", "id");
    }

}