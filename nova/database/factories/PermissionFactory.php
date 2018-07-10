<?php

use Nova\Authorize\Permission;

$factory->define(Permission::class, function ($faker) {
	return [
		'name' => $faker->words(3, true),
		'key' => Str::slug($faker->words(3, true)),
	];
});
