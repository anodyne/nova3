<?php

Route::get('test', function () {
	$character = Nova\Characters\Character::find(2);

	dd($character->positions, $character->primaryPosition);
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
