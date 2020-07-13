<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\States\Types\Primary;
use Nova\Characters\Models\States\Types\Support;
use Nova\Characters\Models\States\Statuses\Active;
use Nova\Characters\Models\States\Types\Secondary;
use Nova\Characters\Models\States\Statuses\Pending;
use Nova\Characters\Models\States\Statuses\Inactive;

$factory->define(Character::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'type' => Support::class,
        'status' => Active::class,
    ];
});

$factory->state(Character::class, 'status:active', ['status' => Active::class]);
$factory->state(Character::class, 'status:inactive', ['status' => Inactive::class]);
$factory->state(Character::class, 'status:pending', ['status' => Pending::class]);

$factory->state(Character::class, 'type:primary', ['type' => Primary::class]);
$factory->state(Character::class, 'type:support', ['type' => Support::class]);
$factory->state(Character::class, 'type:secondary', ['type' => Secondary::class]);
