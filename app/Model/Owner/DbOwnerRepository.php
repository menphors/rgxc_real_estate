<?php

namespace App\Model\Owner;

use App\Model\Owner\OwnerRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbOwnerRepository extends Repository implements OwnerRepository 
{
    public function __construct(Owner $model)
    {
        $this->model = $model;
    }   
}