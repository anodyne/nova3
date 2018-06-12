<?php

$factory->define(Nova\Authorize\Role::class, function ($faker) {
	return [
		'name' => $faker->words(3, true),
	];
});

$factory->afterCreating(Nova\Authorize\Role::class, function ($role, $faker) {
	$role->permissions()->save(factory(Nova\Authorize\Permission::class)->make());
});
