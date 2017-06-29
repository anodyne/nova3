<?php

Route::get('test', function () {
	$theme = new Nova\Foundation\Theme\Theme;

	session()->flash('flash', 'message');

	//dd($theme->iconMap(), $theme->getIcon('delete'), $theme->renderIcon('delete', 'fa-2x'));
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
