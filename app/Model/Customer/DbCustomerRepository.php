<?php

namespace App\Model\Customer;

use App\Model\Customer\CustomerRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbCustomerRepository extends Repository implements CustomerRepository 
{
    public function __construct(Customer $model)
    {
        $this->model = $model;
    }   
}