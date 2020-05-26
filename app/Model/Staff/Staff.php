<?php

namespace App\Model\Staff;

use App\Model\PropertyHasStaff;
use App\Model\PropertyLink;
use App\Model\User\User;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model implements TranslatableContract
{
	use Translatable;

	protected $table = 'staffs';

	public $translatedAttributes = ['username', 'description'];

	protected $fillable = ['name', 'office_id', 'id_card', 'email', 'phone1', 'phone2', 'address', 'fb', 'linkedin', 'thumbnail', 'image', 'gender', 'dob', 'created_by', 'updated_by', 'user_id', "type"];

	public function user()
	{
		return $this->belongsTo(User::class, "user_id", "id");
	}


	public function property_link()
    {
        return $this->hasMany(PropertyLink::class, "agent_id", "id");
    }

	public function property_has_staff()
    {
        return $this->hasMany(PropertyHasStaff::class, "staff_id", "id");
    }

	public function office() {
        return $this->belongsTo('App\Model\Office\Office');
    }

  public function properties()
  {
      return $this->belongsToMany("App\Model\Property\Property", 'property_staff');
  }

  public function sale()
  {
    return $this->hasMany('App\Model\Sale');
  }
}

class StaffTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['username', 'description'];
}