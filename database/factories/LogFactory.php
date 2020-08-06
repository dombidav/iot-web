<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Log;
use Faker\Generator as Faker;

$factory->define(Log::class, function (Faker $faker) {
    return [
        'person_id'=>\App\Worker::All()->random(),
        'subject_id'=>\App\Device::All()->random(),
        'description'=>$faker->paragraph(1),
        'model'=>$faker->randomNumber(1)
    ];
});
