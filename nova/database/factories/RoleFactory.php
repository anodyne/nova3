<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Silber\Bouncer\Database\Role;

$factory->define(Role::class, function (Faker $faker) {
    $name = $faker->words(2, true);

    return [
        'name' => Str::slug($name),
        'title' => $name,
    ];
});
