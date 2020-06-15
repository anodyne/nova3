<?php

use Illuminate\Support\Str;
use Nova\Users\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Nova\Users\Models\States\Active;
use Nova\Users\Models\States\Inactive;
use Nova\Users\Models\States\Pending;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'),
        'pronouns' => $faker->randomElement(['male', 'female', 'neutral']),
        'remember_token' => Str::random(10),
        'status' => Active::class,
    ];
});

$factory->state(User::class, 'unverified-email', [
    'email_verified_at' => null,
]);

$factory->state(User::class, 'forced-password-reset', [
    'force_password_reset' => true,
]);

$factory->state(User::class, 'status:inactive', [
    'status' => Inactive::class,
]);

$factory->state(User::class, 'status:pending', [
    'status' => Pending::class,
]);
