<?php

Route::get('test', function () {
	$role = Nova\Authorize\Role::find(1);

	dd($role, $role->present()->includedPermissions);
});