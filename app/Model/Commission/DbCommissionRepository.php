<?php

namespace App\Model\Commission;

use App\Model\Commission\CommissionRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbCommissionRepository extends Repository implements CommissionRepository 
{
    public function __construct(Commission $model)
    {
        $this->model = $model;
    }   
}