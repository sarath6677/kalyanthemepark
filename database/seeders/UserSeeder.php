<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'f_name' => 'Admin',
                'type' => 0,
                'email' => 'admin@kalyanthemepark.com',
                'phone' => '9876543210',
                'password' => Hash::make('Kalyan@123')
            ],
            [
                'id' => 2,
                'f_name' => 'Vendor',
                'type' => 1,
                'email' => 'Vendor@kalyanthemepark.com',
                'phone' => '9876543211',
                'password' => Hash::make('Kalyan@123')
            ]
        ]);
    }
}
