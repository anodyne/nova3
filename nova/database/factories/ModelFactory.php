<?php

$factory->define(Nova\Users\User::class, function (Faker\Generator $faker) {
	static $password;

	return [
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = 'secret',
		'remember_token' => str_random(10),
	];
});

$factory->define(Nova\Authorize\Role::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(3, true)
	];
});

$factory->define(Nova\Authorize\Permission::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(3, true),
		'key' => Str::slug($faker->words(3, true))
	];
});

$factory->define(Nova\Genres\Department::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(3, true),
		'description' => $faker->sentences(3, true)
	];
});
