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

$factory->define(App\AccountTab::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'account_id' => function () {
            return factory(App\Account::class)->create()->id;
        }
    ];
});
