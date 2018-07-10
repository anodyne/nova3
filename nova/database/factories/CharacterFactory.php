<?php

use Nova\Users\User;
use Nova\Genres\Rank;
use Nova\Characters\Character;

$factory->define(Character::class, function ($faker) {
	return [
		'rank_id' => function () {
			return factory(Rank::class)->create()->id;
		},
		'user_id' => function () {
			return factory(User::class)->create()->id;
		},
		'name' => sprintf('%s %s', $faker->firstName(), $faker->lastName),
	];
});
