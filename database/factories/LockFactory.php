<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Helpers\AccessControlSystem;
use App\Lock;
use Faker\Generator as Faker;

$factory->define(Lock::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20),
        'status' => AccessControlSystem::Operational,
        'timeout' => $faker->numberBetween(0, 30)
    ];
});
