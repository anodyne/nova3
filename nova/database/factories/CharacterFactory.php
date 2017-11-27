<?php

use Faker\Generator as Faker;

$factory->define(Nova\Characters\Character::class, function (Faker $faker) {
	return [
		'rank_id' => function () {
			return factory(Nova\Genres\Rank::class)->create()->id;
		},
		'user_id' => function () {
			return factory(Nova\Users\User::class)->create()->id;
		},
		'name' => "{$faker->firstName()} {$faker->lastName}",
	];
});
