<?php

namespace App\Model\Commune;

use App\Model\Commune\CommuneRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbCommuneRepository extends Repository implements CommuneRepository 
{
    public function __construct(Commune $model)
    {
        $this->model = $model;
    }   

    public function lists()
    {
        return $this->model->join('commune_translations as t', function ($join) {
            $join->on('communes.id', '=', 't.commune_id')
                ->where('t.locale', '=', \LaravelLocalization::getCurrentLocale());
        })
        ->select('communes.*', 't.title')
        ->with('translations');
    }
}