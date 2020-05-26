<?php

namespace App\Model\PaymentTransaction;

use App\Model\PaymentTransaction\PaymentTransactionRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbPaymentTransactionRepository extends Repository implements PaymentTransactionRepository 
{
    public function __construct(PaymentTransaction $model)
    {
        $this->model = $model;
    }   
}