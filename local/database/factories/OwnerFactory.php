<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\DTO\Owner::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'password' => bcrypt($faker->password),
        'email' => $faker->email,
        'surname' => $faker->name,
        'phone' => $faker->phoneNumber,
        'owner' => true,
        'admin' => false,
    ];
});