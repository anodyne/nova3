<?php

Route::get('test', function () {
	$finder = (new Nova\Genres\RankFinder)->getBaseImages();

	dd($finder);
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
