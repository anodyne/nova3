<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Nova\Themes\Models\Theme;

$factory->define(Theme::class, function (Faker $faker) {
    $name = $faker->words(mt_rand(1, 3), true);

    return [
        'name' => ucfirst($name),
        'location' => Str::slug($name),
        'active' => true,
    ];
});

$factory->state(Theme::class, 'inactive', [
    'active' => false,
]);
