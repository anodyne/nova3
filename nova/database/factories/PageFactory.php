<?php

use Nova\Pages\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
		'name' => ucwords($faker->words(3, true)),
		'key' => $faker->word,
		'uri' => '',
		'resource' => '',
    ];
});

$factory->state(Page::class, 'post', ['verb' => 'post']);
$factory->state(Page::class, 'put', ['verb' => 'put']);
$factory->state(Page::class, 'patch', ['verb' => 'patch']);
$factory->state(Page::class, 'delete', ['verb' => 'delete']);
