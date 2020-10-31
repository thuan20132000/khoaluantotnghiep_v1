<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Category;
use App\Model\Occupation;
use Faker\Generator as Faker;

$factory->define(Occupation::class, function (Faker $faker) {
    return [
        //
        'name'=>$faker->word,
        'slug'=>$faker->slug,
        'category_id'=>function(){
            return Category::all()->random();
        }
    ];
});
