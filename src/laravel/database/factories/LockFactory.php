<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\AccessControlSystem;
use App\Lock;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Lock::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20),
        'device_id'=> Str::random(16),
        'status' => AccessControlSystem::Operational,
        'timeout' => $faker->numberBetween(0, 30)
    ];
});
