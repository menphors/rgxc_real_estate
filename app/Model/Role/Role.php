<?php 

namespace App\Model\Role;

use App\Model\ModelHasRole;
use Illuminate\Database\Eloquent\Model;

class Role extends \Spatie\Permission\Models\Role
{
    protected $table = "roles";

//     protected $fillable = ['role_type'];
//
//     public function permissions() {
//     	return $this->belongsToMany('App\Model\Permission\Permission','role_has_permissions');
//     }
//
//     public function roles() {
//     	return $this->belongsToMany('App\Model\User\User', 'user_has_roles');
//     }

    public function model_has_roles()
    {
        return $this->hasMany(ModelHasRole::class, "role_id", "id");
    }
}