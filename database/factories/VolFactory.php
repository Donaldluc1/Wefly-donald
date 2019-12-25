<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Vol::class, function (Faker $faker) {
    return [
        'dateDepart' => $faker->date('Y-m-d'),
        'heureDepart' => $faker->time('H-m-s'),
        'dateArrivee' => $faker->date('Y-m-d'),
        'heureArrivee' => $faker->time('H-m-s')
    ];
});
