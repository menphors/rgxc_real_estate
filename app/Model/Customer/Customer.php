<?php

namespace App\Model\Customer;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

	protected $fillable = [
	    'name',
	    'id_card',
        'email',
        'phone',
        'phone2',
        'address',
        'thumbnail',
        'image',
        'gender',
        'dob',
        'created_by',
        'updated_by',
        'verified_code',
        'expired',
        'verified_status',
        'last_active',
        "password",
        "wechat",
        "telegram",
        "language",
        "fb",
        "linkedin",
    ];

}
