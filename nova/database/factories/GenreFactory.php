<?php

use Faker\Generator as Faker;

$factory->define(Nova\Genres\Department::class, function (Faker $faker) {
	return [
		'name' => $faker->words(3, true),
		'description' => $faker->sentences(3, true)
	];
});

$factory->define(Nova\Genres\Position::class, function (Faker $faker) {
	return [
		'name' => $faker->words(2, true),
		'description' => $faker->sentences(3, true),
		'department_id' => function () {
			return factory(Nova\Genres\Department::class)->create()->id;
		},
		'available' => 1
	];
});

$factory->states(Nova\Genres\Position::class, 'available', [
	'available' => 1
]);

$factory->states(Nova\Genres\Position::class, 'unavailable', [
	'available' => 0
]);

$factory->define(Nova\Genres\RankGroup::class, function (Faker $faker) {
	return [
		'name' => $faker->words(2, true),
	];
});

$factory->define(Nova\Genres\RankInfo::class, function (Faker $faker) {
	return [
		'name' => $faker->words(2, true),
		'short_name' => $faker->words(1, true),
	];
});

$factory->define(Nova\Genres\Rank::class, function (Faker $faker) {
	return [
		'group_id' => function () {
			return factory(Nova\Genres\RankGroup::class)->create()->id;
		},
		'info_id' => function () {
			return factory(Nova\Genres\RankInfo::class)->create()->id;
		},
		'base' => 'foo.png',
		'overlay' => 'bar.png',
	];
});
