<?php

Route::get('test', function () {
	$character1 = Nova\Characters\Character::find(3);
	$character2 = Nova\Characters\Character::find(2);
	$position = Nova\Genres\Position::find(1);

	return view('pages.test', compact('position', 'character1', 'character2'));
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
