<?php

use Nova\Authorize\Role;
use Nova\Authorize\Permission;

$factory->define(Role::class, function ($faker) {
	return [
		'name' => $faker->words(3, true),
	];
});
