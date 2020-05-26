<?php

namespace App\Model\Property;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

use App\Model\Commune\Commune;
use App\Model\District\District;
use App\Model\Owner\Owner;
use App\Model\PropertyHasOwner;
use App\Model\PropertyHasStaff;
use App\Model\PropertyLink;
use App\Model\PropertyType;
use App\Model\Contract\Contract;
use App\Model\Province\Province;
use App\Model\Village\Village;
use App\Model\Attachment\Attachment;

class Property extends Model implements TranslatableContract
{
	use Translatable;

  use SoftDeletes;

	public $translatedAttributes = ['title', 'remark'];

	protected $fillable = ['code', 'project_id', 'property_type_id', 'listing_type', 'cost', 'price_sqm', 'price', 'property_size', 'floor_number', 'bed_room', 'bath_room', 'latitude', 'longitude', 'created_by', 'updated_by', 'user_id', 'type_id', 'display_on_maps', 'year_of_renovation', 'year_of_construction', 'built_up_surface', 'habitable_surface', 'ground_surface', 'has_swimming_pool', 'has_elevator', 'address', 'has_basement', 'thumbnail', '', 'status', 'state', 'is_published', 'data', 'has_parking', 'province_id', 'district_id', 'commune_id', 'village_id', 'owner_id', "is_home"];


	public function province_id()
    {
        return $this->belongsTo(Province::class, "province_id", "id");
    }

    public function district_id()
    {
        return $this->belongsTo(District::class, "district_id", "id");
    }

    public function commune_id()
    {
        return $this->belongsTo(Commune::class, "commune_id", "id");
    }

    public function village_id()
    {
        return $this->belongsTo(Village::class, "village_id", "id");
    }

    public function property_type_id()
    {
        return $this->belongsTo(PropertyType::class, "property_type_id", "id");
    }

    public function property_type()
    {
        return $this->belongsTo(PropertyType::class, "property_type_id", "id");
    }

    public function owner_id()
    {
        return $this->belongsTo(Owner::class, "owner_id", "id");
    }

    public function owner()
    {
        return $this->hasMany(PropertyHasOwner::class, "property_id", "id");
    }

    public function collector()
    {
        return $this->hasMany(PropertyHasStaff::class, "property_id", "id");
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function commune()
    {
        return $this->belongsTo(Commune::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'object_id', 'id')
            ->where(["key" => "properties"]);
    }

    public function propertyLink()
    {
        return $this->hasMany(PropertyLink::class, "property_id", "id");
    }

    public function property_has_staff()
    {
        return $this->hasMany(PropertyHasStaff::class, "property_id", "id");
    }

    public function contracts()
    {
      return $this->hasMany(Contract::class, 'property_id', 'id');
    }

    public function property_tag()
    {
        return $this->hasMany(\App\Model\PropertyTag::class, "property_id", "id");
    }
}

// public function users() {
	
// }

class PropertyTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['title', 'remark'];
}