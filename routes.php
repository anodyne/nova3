<?php

Route::get('test', function () {
	$role = Nova\Authorize\Role::find(1);

	dd($role, $role->present()->includedPermissions);
});

Route::get('status', function () {
	return view('pages.status');
})->name('status');
