<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Characters\Models\Character;

$factory->define(Character::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
