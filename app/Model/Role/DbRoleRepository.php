<?php 

namespace App\Model\Role;

use App\Model\Role\RoleRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbRoleRepository extends Repository implements RoleRepository {


    public function __construct(Role $model)
    {
        $this->model = $model;
    }   

    // public function getList() {
    // 	return $this->model()->where('name','!=','admin')->pluck('name','id');
    // }

    // public function getRolePerPage($limit = 10) {
    // 	return $this->model()->paginate($limit);
    // }

}