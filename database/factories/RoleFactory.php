<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Role;
use App\User;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        //
        'role_id'=>function(){
            return Role::all()->random();
        },
        'user_id'=>function(){
            return User::all()->random();
        }
    ];
});
