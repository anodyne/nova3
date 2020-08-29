<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Stories\Models\Story;
use Nova\Stories\Models\States\Current;
use Nova\Stories\Models\States\Upcoming;
use Nova\Stories\Models\States\Completed;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'title' => ucfirst($faker->words($faker->numberBetween(1, 5), true)),
        'status' => $faker->randomElement([Upcoming::class, Current::class, Completed::class]),
        'description' => $faker->sentences($faker->numberBetween(1, 5), true),
        'parent_id' => 1,
    ];
});

$factory->state(Story::class, 'status:upcoming', [
    'status' => Upcoming::class,
]);

$factory->state(Story::class, 'status:current', [
    'status' => Current::class,
]);

$factory->state(Story::class, 'status:completed', [
    'status' => Completed::class,
]);

$factory->state(Story::class, 'with:start', function (Faker $faker) {
    return [
        'start_date' => $faker->date(),
    ];
});

$factory->state(Story::class, 'with:end', function (Faker $faker) {
    return [
        'end_date' => $faker->date(),
    ];
});
