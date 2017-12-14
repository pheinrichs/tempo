<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Contact::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'account_id' => function () {
            return factory(App\Account::class)->create()->id;
        },
        'mobile_phone' => $faker->phoneNumber,
        'home_phone' => $faker->phoneNumber,
        'work_phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'primary' => false
    ];
});
