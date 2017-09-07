<?php

use Faker\Generator as Faker;

$factory->define(Nova\Authorize\Role::class, function (Faker $faker) {
	return [
		'name' => $faker->words(3, true)
	];
});

$factory->define(Nova\Authorize\Permission::class, function (Faker $faker) {
	return [
		'name' => $faker->words(3, true),
		'key' => Str::slug($faker->words(3, true))
	];
});
