<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Channel::class, function (Faker $faker) {
    $name = $faker->firstName;
    return [
        'name' => $name,
        'description' => $faker->sentence,
        'slug' => Str::slug($name),
    ];
});
