<?php

Route::get('test', function () {
	//
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
