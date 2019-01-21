<?php

use Nova\Themes\Theme;
use Faker\Generator as Faker;

$factory->define(Theme::class, function (Faker $faker) {
    $name = $faker->word;

    return [
        'name' => ucfirst($name),
        'location' => strtolower($name),
        'layout_auth' => strtolower($faker->word),
        'layout_admin' => strtolower($faker->word),
        'layout_public' => strtolower($faker->word),
    ];
});
