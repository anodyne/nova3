<?php

Route::get('test', function () {
	view()->share('_user', auth()->user());
	return view('pages.test');
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
