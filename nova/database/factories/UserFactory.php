<?php

use Nova\Users\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => Hash::make('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->state(User::class, 'unverified-email', [
    'email_verified_at' => null
]);

$factory->state(User::class, 'forced-password-reset', [
    'force_password_reset' => true
]);
