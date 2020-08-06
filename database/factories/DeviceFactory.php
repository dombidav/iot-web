<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Device;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20),
        'category'=>$faker->randomNumber(1)
    ];
});
