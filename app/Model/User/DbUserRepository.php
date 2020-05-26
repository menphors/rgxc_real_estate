<?php namespace App\Model\User;

use App\Model\User\UserRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbUserRepository extends Repository implements UserRepository {

	public function __construct(User $model) {
		$this->model = $model;
	}

	public function getUserPerPage($role, $limit) {
      return $this->model()
                  ->whereHas("roles",function($q) use ($role){
                      if(is_numeric($role) && $role > 0){
                          $q->where("roles.id","=",$role);
                      }
                  })
                  ->select('users.*')
                  ->orderBy('users.id','DESC')
                  ->paginate($limit);
  }
  
}