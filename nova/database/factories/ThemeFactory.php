<?php

use Faker\Generator as Faker;

$factory->define(Nova\Themes\Theme::class, function (Faker $faker) {
	$word = $faker->word;

    return [
		'name' => ucwords($word),
		'path' => $word
    ];
});

$factory->state(Nova\Themes\Theme::class, 'pulsar', [
	'name' => 'Pulsar',
	'path' => 'pulsar',
	'layout_auth' => 'auth-basic',
	'layout_data_auth' => [
		'image' => '/themes/pulsar/design/images/auth-cover.svg'
	]
]);
