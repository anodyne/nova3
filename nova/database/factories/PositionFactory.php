<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Departments\Models\Position;
use Nova\Departments\Models\Department;

$factory->define(Position::class, function (Faker $faker) {
    return [
        'name' => ucwords($faker->words($faker->numberBetween(1, 3), true)),
        'description' => $faker->sentence,
        'active' => true,
        'available' => $faker->numberBetween(1, 5),
        'department_id' => function () {
            return factory(Department::class)->create()->id;
        },
    ];
});

$factory->state('inactive', Position::class, [
    'active' => false,
]);

$factory->state('unavailable', Position::class, [
    'available' => 0,
]);
