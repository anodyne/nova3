<?php

$factory->define(Nova\Authorize\Permission::class, function ($faker) {
	return [
		'name' => $faker->words(3, true),
		'key' => Str::slug($faker->words(3, true)),
	];
});
