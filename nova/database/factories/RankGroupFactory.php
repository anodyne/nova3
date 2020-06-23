<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Nova\Ranks\Models\RankGroup;

$factory->define(RankGroup::class, function (Faker $faker) {
    return [
        'name' => ucfirst($faker->word),
    ];
});
