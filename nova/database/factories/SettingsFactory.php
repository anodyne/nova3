<?php

$factory->define(Nova\Settings\Settings::class, function ($faker) {
	return [
		'key' => $faker->words(1, true),
		'value' => $faker->words(3, true),
	];
});
