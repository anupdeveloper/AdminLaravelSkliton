<?php

namespace Database\Seeders;

use App\Models\MasterSect;
use App\Models\MasterTribe;
use App\Models\MasterWork;
use Countries;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        
    }
}
