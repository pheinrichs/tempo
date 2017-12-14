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

$factory->define(App\TabField::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'value' => $faker->word,
        'tab_id' => function() {
            return factory(App\AccountTab::class)->create()->id;
        }
    ];
});
