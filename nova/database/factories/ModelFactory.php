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

$factory->define(Nova\Genres\Position::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(2, true),
		'description' => $faker->sentences(3, true),
		'department_id' => function () {
			return factory('Nova\Genres\Department')->create()->id;
		}
	];
});

$factory->define(Nova\Genres\RankGroup::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(2, true),
	];
});

$factory->define(Nova\Genres\RankInfo::class, function (Faker\Generator $faker) {
	return [
		'name' => $faker->words(2, true),
		'short_name' => $faker->words(1, true),
	];
});

$factory->define(Nova\Genres\Rank::class, function (Faker\Generator $faker) {
	return [
		'group_id' => function () {
			return factory('Nova\Genres\RankGroup')->create()->id;
		},
		'info_id' => function () {
			return factory('Nova\Genres\RankInfo')->create()->id;
		},
		'base' => 'foo.png',
		'overlay' => 'bar.png',
	];
});

$factory->define(Nova\Settings\Settings::class, function (Faker\Generator $faker) {
	return [
		'key' => $faker->words(1, true),
		'value' => $faker->words(3, true),
	];
});

$factory->define(Nova\Characters\Character::class, function (Faker\Generator $faker) {
	return [
		'user_id' => function () {
			return factory('Nova\Users\User')->create()->id;
		},
		'position_id' => function () {
			return factory('Nova\Genres\Position')->create()->id;
		},
		'rank_id' => function () {
			return factory('Nova\Genres\Rank')->create()->id;
		},
		'name' => "{$faker->firstName()} {$faker->lastName}",
	];
});
