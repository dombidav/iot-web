<?php

/** @var Factory $factory */

use App\Device;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20),
        'category'=>(['other', 'thermometer', 'heater', 'lock', 'fan'])[rand(0, 4)]
    ];
});
