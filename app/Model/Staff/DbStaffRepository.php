<?php

namespace App\Model\Staff;

use App\Model\Staff\StaffRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbStaffRepository extends Repository implements StaffRepository 
{
    public function __construct(Staff $model)
    {
        $this->model = $model;
    }   
}