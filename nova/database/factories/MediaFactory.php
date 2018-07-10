<?php

use Nova\Media\Media;
use Nova\Characters\Character;

$factory->define(Media::class, function ($faker) {
	$character = factory(Character::class)->create();

	return [
		'mediable_id' => $character->id,
		'mediable_type' => 'character',
		'filename' => Str::random().'.png',
		'mime_type' => 'image/png',
	];
});
