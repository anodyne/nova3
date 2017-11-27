<?php

use Illuminate\Http\Request;

Route::get('characters', function () {
	return Nova\Characters\Character::with(['user', 'positions', 'rank.info'])
		->active()
		->get();
})->name('api.characters');

Route::get('departments', function () {
	return Nova\Genres\Department::with('positions', 'subDepartments.positions')->get();
})->name('api.departments');

Route::get('positions', function () {
	return Nova\Genres\Position::with('department')->get();
})->name('api.positions');

Route::get('ranks', function () {
	return Nova\Genres\Rank::with('info', 'group')->get();
})->name('api.ranks');

Route::get('users', function () {
	return Nova\Users\User::with('characters', 'allCharacters')
		->active()
		->get();
})->name('api.users');
