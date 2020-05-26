<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Model\User\User;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$permission = [        
            ['name' => 'view_user', 'title' => 'View User'],
            ['name' => 'add_user', 'title' => 'Add User'],
            ['name' => 'edit_user', 'title' => 'Edit User'],
            ['name' => 'delete_user', 'title' => 'Delete User'],

            ['name' => 'view_role', 'title' => 'View Role'],
            ['name' => 'add_role', 'title' => 'Add Role'],
            ['name' => 'edit_role', 'title' => 'Edit Role'],
            ['name' => 'delete_role', 'title' => 'Delete Role'],

            ['name' => 'create_property', 'title' => 'Create Property'],
            ['name' => 'update_property', 'title' => 'Update Property'],
            ['name' => 'delete_property', 'title' => 'Delete Property'],
            ['name' => 'commission_property', 'title' => 'Commission Property'],
            ['name' => 'assign-staff_property', 'title' => 'Assign Staff Property'],
            ['name' => 'contract_property', 'title' => 'Contract Property'],
      	];

      	foreach($permission as $per){
            Permission::create($per);
        }

        $permissions = Permission::pluck('name', 'id')->toArray();
        $role = Role::create(['name' => 'admin', 'title' => 'Administrator']);
        $role->syncPermissions($permissions);

        $user = User::where('name', 'Admin')->first();
        if ($user)
        {
            $user->assignRole($role->name);
        }
        else
        {
            $user = User::create(
                [
                    'name'  =>  'Admin',
                    'email' =>  'kosal.web@gmail.com',
                    'password'  => '111111',
                    'status'    =>  true,
                    'is_admin'  => true
                ]
            );
            $user->assignRole($role->name);
        }

        // Assign default role 'admin' to all users
        $users = \User::doesntHave("roles")->get();
        foreach ($users as $u)
        {
            $u->assignRole($role->name);
        }
    }
}
