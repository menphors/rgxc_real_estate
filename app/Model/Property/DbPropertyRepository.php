<?php

namespace App\Model\Property;

use App\Repositories\Repository;
class DbPropertyRepository extends Repository implements PropertyRepository
{
    public function __construct(Property $model)
    {
        $this->model = $model;
    }

    public function property($id)
    {
        return $this->model->join('property_translations as p', function ($join) {
            $join->on('properties.id', '=', 'p.property_id')
                ->where('p.locale', '=', \LaravelLocalization::getCurrentLocale());
            })
            ->where("properties.id", $id)
            ->select('properties.*', 'p.title', 'p.remark')
            ->with('translations');
    }
}