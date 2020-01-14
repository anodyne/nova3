<?php

use Nova\Themes\Models\Theme;
use Faker\Generator as Faker;

$factory->define(Theme::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => ucfirst($name),
        'location' => strtolower($name),
    ];
});
