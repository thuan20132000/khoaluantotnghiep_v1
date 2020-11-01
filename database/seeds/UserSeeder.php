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

        for ($i=0; $i < 10; $i++){
            # code...
            // $param = (string)$i;
            // $email = 'thuan'+$param+'@gmail.com';
            $customer =User::create([
                'name' => $i,
                'email' => rand(1000,100000),
                'password' => Hash::make('user'),
            ]);
            $customer->roles()->attach(3);
        }



    }
}
