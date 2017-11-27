<?php

use Faker\Generator as Faker;

$factory->define(Nova\Settings\Settings::class, function (Faker $faker) {
	return [
		'key' => $faker->words(1, true),
		'value' => $faker->words(3, true),
	];
});
