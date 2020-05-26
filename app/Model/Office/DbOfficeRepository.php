<?php

namespace App\Model\Office;

use App\Model\Office\OfficeRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbOfficeRepository extends Repository implements OfficeRepository 
{
    public function __construct(Office $model)
    {
        $this->model = $model;
    }   
}