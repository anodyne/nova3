<?php

$factory->define(Nova\Characters\Character::class, function ($faker) {
	return [
		'rank_id' => function () {
			return factory(Nova\Genres\Rank::class)->create()->id;
		},
		'user_id' => function () {
			return factory(Nova\Users\User::class)->create()->id;
		},
		'name' => sprintf('%s %s', $faker->firstName(), $faker->lastName),
	];
});
