<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Role::create(['name'=>'User']);

       Permission::create(['name'=>'user.create']);
       Permission::create(['name'=>'user.edit']);
       Permission::create(['name'=>'user.delete']);
       
       Permission::create(['name'=>'student.create']);
       Permission::create(['name'=>'student.edit']);
       Permission::create(['name'=>'student.delete']);


    }
}
