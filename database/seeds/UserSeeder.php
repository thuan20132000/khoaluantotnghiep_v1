<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = new Faker();
        $user = User::create([
            'name' => ' admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);
        $user->roles()->attach(1);
        factory(User::class,20)->create();

    }
}
