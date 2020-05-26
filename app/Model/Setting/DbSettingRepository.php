<?php

namespace App\Model\Setting;

use App\Model\Setting\SettingRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbSettingRepository extends Repository implements SettingRepository 
{
    public function __construct(Setting $model)
    {
        $this->model = $model;
    }   
}