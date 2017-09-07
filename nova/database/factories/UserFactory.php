<?php

use Faker\Generator as Faker;

$factory->define(Nova\Users\User::class, function (Faker $faker) {
	static $password;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = 'secret',
		'remember_token' => str_random(10),
	];
});
