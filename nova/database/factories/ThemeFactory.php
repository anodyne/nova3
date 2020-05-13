<?php

use Faker\Generator as Faker;
use Nova\Themes\Models\Theme;

$factory->define(Theme::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => ucfirst($name),
        'location' => strtolower($name),
        'active' => true,
    ];
});

$factory->state(Theme::class, 'inactive', [
    'active' => false,
]);
