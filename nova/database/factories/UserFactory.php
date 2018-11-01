<?php

use Nova\Users\User;
use Nova\Authorize\Role;

$factory->define(User::class, function ($faker) {
	static $password;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'email_verified_at' => now(),
		'password' => $password ?: $password = 'secret',
		'remember_token' => str_random(10),
	];
});

$factory->afterCreatingState(User::class, 'admin', function ($user, $faker) {
	$user->attachRole(Role::firstOrCreate(['name' => 'System Admin']));
});

$factory->afterCreatingState(User::class, 'power-user', function ($user, $faker) {
	$user->attachRole(Role::firstOrCreate(['name' => 'Power User']));
});

$factory->afterCreatingState(User::class, 'active-user', function ($user, $faker) {
	$user->attachRole(Role::firstOrCreate(['name' => 'Active User']));
});

$factory->afterCreatingState(User::class, 'inactive-user', function ($user, $faker) {
	$user->attachRole(Role::firstOrCreate(['name' => 'Inactive User']));
});
