<?php

/** @var Factory $factory */

use App\Device;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20),
        'deviceID' => Str::random(32),
        'category'=>(['other', 'thermometer', 'heater', 'lock', 'fan'])[rand(0, 4)],
        'timeout' => $faker->numberBetween(0, 30)
    ];
});
