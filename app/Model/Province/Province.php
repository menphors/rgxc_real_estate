<?php

namespace App\Model\Province;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use App\Model\District\District;

class Province extends Model implements TranslatableContract
{
	use Translatable;

	protected $table = 'provinces';

	public $translatedAttributes = ["title"];

	protected $fillable = ['code'];

	public function provinceDistrict()
	{
		return $this->hasMany('App\Model\District\District', 'province_id', 'id');
	}


}

class ProvinceTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ["province_id", "locale", 'title'];
}