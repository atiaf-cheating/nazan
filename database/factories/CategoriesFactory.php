<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'arabic_name' => $faker->name,
        'english_name' => $faker->name,
        'created_at' => now(),
        'updated_at' => now(),
        'image_url' => 'app/test'
    ];
});
