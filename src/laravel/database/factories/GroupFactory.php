<?php

/** @var Factory $factory */

use App\Group;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'name'=>$faker->text(20)
    ];
});
