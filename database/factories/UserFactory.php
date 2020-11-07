<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'email' => $faker->email,
        'email_verified_at' => now(),
        'password' => Hash::make('Thuan123'), // password
        'remember_token' => Str::random(10),
        'phonenumber'=>$faker->phoneNumber,
        'idcard'=>random_int(1,10),
        'address'=>$faker->address,
        'status'=>random_int(0,2),
    ];
});
