<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            //'name' => 'Admin',
            'email' => 'admin@admin.com',
            'mobile' => '511111111',
            'password' => Hash::make('123456'),
            
        ]);

        User::create([
            //'name' => 'Rahul',
            'email' => 'rahul@gmail.com',
            'mobile' => '522222222',
            'password' => Hash::make('123456'),
            "username" => "rahul1234",
           

        ]);



    }
}
