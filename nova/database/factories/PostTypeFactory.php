<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\PostTypes\Models\PostType;

$factory->define(PostType::class, function (Faker $faker) {
    $word = $faker->word;

    return [
        'name' => ucfirst($word),
        'key' => $word,
    ];
});
