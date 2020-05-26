<?php

use Illuminate\Database\Seeder;

class StaffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(
	                [
	                    'name'  =>  'Staff',
	                    'email' =>  'staff@gmail.com',
	                    'password'  => bcrypt('111111'),
	                    'status'    =>  true,
	                    'is_admin'  => true
	                ]
	            );
        $user->staff()->create([
            'id_card' => '111111',
            'email' => 'staff@gmail.com',
            'phone1' => '0987654321',
            'address' => 'Phnom Penh',
            'fb' => 'facebook.com',
            'username' => 'staff 001',
            'created_by' => 1,
            'dob' => Date('Y-m-d H:i:s')
        ]);
        dd('Default staff added successfully!');
    }
}
