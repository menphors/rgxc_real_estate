<?php

namespace App\Model\District;

use App\Model\District\DistrictRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbDistrictRepository extends Repository implements DistrictRepository 
{
    public function __construct(District $model)
    {
        $this->model = $model;
    }   

    public function lists()
    {
        return $this->model->join('district_translations as t', function ($join) {
            $join->on('districts.id', '=', 't.district_id')
                ->where('t.locale', '=', \LaravelLocalization::getCurrentLocale());
        })
        ->select('districts.*', 't.title')
        ->with('translations');
    }
}