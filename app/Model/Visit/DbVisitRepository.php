<?php

namespace App\Model\Visit;

use App\Model\Visit\VisitRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbVisitRepository extends Repository implements VisitRepository 
{
    public function __construct(Visit $model)
    {
        $this->model = $model;
    }   
}