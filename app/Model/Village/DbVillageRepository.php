<?php

namespace App\Model\Village;

use App\Model\Village\VillageRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbVillageRepository extends Repository implements VillageRepository 
{
    public function __construct(Village $model)
    {
        $this->model = $model;
    }   

    public function lists()
    {
        return $this->model->join('village_translations as t', function ($join) {
            $join->on('villages.id', '=', 't.village_id')
                ->where('t.locale', '=', \LaravelLocalization::getCurrentLocale());
        })
        ->select('villages.*', 't.title')
        ->with('translations');
    }
}