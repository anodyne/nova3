<?php

use Illuminate\Support\Str;
use Nova\Roles\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    $name = $faker->words(2, true);

    return [
        'name' => Str::slug($name),
        'display_name' => $name,
        'locked' => false,
        'default' => false,
    ];
});

$factory->state(Role::class, 'default', [
    'default' => true,
]);

$factory->state(Role::class, 'locked', [
    'locked' => true,
]);
