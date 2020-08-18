<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\PostTypes\Models\PostType;

$factory->define(PostType::class, function (Faker $faker) {
    $word = $faker->word;

    return [
        'active' => $faker->randomElement([true, false]),
        'description' => $faker->sentence,
        'key' => $faker->lexify("{$word}-????"),
        'name' => ucfirst($word),
        'visibility' => $faker->randomElement(['in-character', 'out-of-character']),
        'color' => $faker->hexColor,
        'icon' => 'book',
    ];
});
