<?php

namespace App\Model\Permission;

use App\Model\Permission\PermissionRepository;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;

class DbPermissionRepository extends Repository implements PermissionRepository 
{
    public function __construct(Permission $model)
    {
        $this->model = $model;
    }   

    public function listPermissions()
    {
        $permissions = $this->model->pluck('name', 'id');
        $listPer = [];
        foreach ($permissions as $key => $per)
        {
            $arr_per = explode('.', $per);
            switch ($arr_per[0]) {
                case 'role':
                    $listPer['Role Management'][$key] = $per;
                    break;
                case 'type':
                    $listPer['Type Management'][$key] = $per;
                    break;
                case 'tag':
                    $listPer['Tag Management'][$key] = $per;
                    break;
                case 'location':
                    $listPer['Location Management'][$key] = $per;
                    break;
                case 'customer':
                    $listPer['Customer Management'][$key] = $per;
                    break;
                case 'owner':
                    $listPer['Owner Management'][$key] = $per;
                    break;
                case 'project':
                    $listPer['Project Management'][$key] = $per;
                    break;
                case 'property':
                    $listPer['Property Management'][$key] = $per;
                    break;
                case 'staff':
                    $listPer['Staff Management'][$key] = $per;
                    break;
                case 'office':
                    $listPer['Office Management'][$key] = $per;
                    break;
                case 'cms':
                    $listPer['Content Management'][$key] = $per;
                    break;
                case 'report':
                    $listPer['Reports'][$key] = $per;
                    break;
                case 'sale':
                    $listPer['Sale Management'][$key] = $per;
                    break;
                default:
                    $listPer['User Management'][$key] = $per;
                    break;
            }
        }

        return $listPer;
    }
}
