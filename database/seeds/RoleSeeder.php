<?php

use App\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //


        Role::create(['name' => 'isAdmin']);
        Role::create(['name' => 'isCollaborator']);
        Role::create(['name' => 'isCustomer']);


    }
}
