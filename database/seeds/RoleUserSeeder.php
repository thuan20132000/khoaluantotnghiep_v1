<?php

use App\Model\RoleUser;
use App\Role;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(RoleUser::class,20)->create();
    }
}
