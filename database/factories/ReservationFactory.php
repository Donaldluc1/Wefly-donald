<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Reservation::class, function (Faker $faker) {
    return [
        'date' => $faker->date('Y-m-d'),
        'numero' => $faker->numberBetween(10, 100),
        'vol_id' => $faker->numberBetween(0, 30)
    ];
});
