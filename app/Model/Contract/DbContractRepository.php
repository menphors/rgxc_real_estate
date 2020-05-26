<?php

namespace App\Model\Contract;

use App\Model\Contract\ContractRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbContractRepository extends Repository implements ContractRepository 
{
    public function __construct(Contract $model)
    {
        $this->model = $model;
    }   
}