<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
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
	                    'name'  =>  'Customer',
	                    'email' =>  'customer@gmail.com',
	                    'password'  => bcrypt('111111'),
	                    'status'    =>  true,
	                    'is_admin'  => false
	                ]
	            );
        $user->customer()->create([
            'id_card' => '111111',
            'email' => 'customer@gmail.com',
            'phone' => '0987654321',
            'address' => 'Phnom Penh',
            'username' => 'staff 001',
            'created_by' => 1,
            'dob' => Date('Y-m-d')
        ]);
        dd('Default customer added successfully!');
    }
}
