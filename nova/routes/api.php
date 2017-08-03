<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('characters', function () {
	return Nova\Characters\Character::with(['user', 'position', 'rank.info'])
		->where('status', Status::ACTIVE)
		->get();
})->name('api.characters');

Route::get('ranks', function () {
	return Nova\Genres\Rank::with('info', 'group')->get();
})->name('api.ranks');

Route::get('users', function () {
	return Nova\Users\User::where('status', Status::ACTIVE)->get();
})->name('api.users');
