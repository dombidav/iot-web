<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\WorkerGroup;
use Faker\Generator as Faker;

$factory->define(WorkerGroup::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20)
    ];
});
