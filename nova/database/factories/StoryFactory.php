<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Nova\Stories\Models\States\Stories\Completed;
use Nova\Stories\Models\States\Stories\Current;
use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Stories\Upcoming;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->words($faker->numberBetween(1, 5), true)),
        'status' => $faker->randomElement([Upcoming::class, Current::class, Completed::class]),
        'description' => $faker->sentences($faker->numberBetween(1, 5), true),
    ];
});
