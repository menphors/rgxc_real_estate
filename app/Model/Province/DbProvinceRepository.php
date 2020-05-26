<?php

namespace App\Model\Province;

use App\Model\Province\ProvinceRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbProvinceRepository extends Repository implements ProvinceRepository 
{
    public function __construct(Province $model)
    {
        $this->model = $model;
    }   

    public function lists()
    {
        return $this->model->join('province_translations as t', function ($join) {
            $join->on('provinces.id', '=', 't.province_id')
                ->where('t.locale', '=', \LaravelLocalization::getCurrentLocale());
        })
        ->select('provinces.*', 't.title');
    }
}