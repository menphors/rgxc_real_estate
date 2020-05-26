<?php

namespace App\Model;

use App\Model\Role\Role;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;

class ModelHasRole extends Model
{
    protected $table = "model_has_roles";

    public function role()
    {
        return $this->belongsTo(Role::class, "role_id", "id");
    }

    public function user()
    {
        return $this->belongsTo(User::class, "model_id", "id");
    }
}
