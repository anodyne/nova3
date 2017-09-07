<?php

use Illuminate\Foundation\Inspiring;

Artisan::command('inspire', function () {
	$this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('nova:refresh', function () {
	// Flush the caches
	Cache::flush();
	Session::flush();
	Artisan::call('cache:clear');
	Artisan::call('config:clear');
	Artisan::call('route:clear');
	$this->info('Cleared system caches.');

	// Refresh the migrations
	Artisan::call('migrate:fresh', ['--force' => true]);
	$this->info('Refreshed database.');

	// Create a user with the System Admin role
	$admin = factory('Nova\Users\User')->create([
		'name' => "Adam Doe",
		'email' => "admin@example.com",
		'remember_token' => null,
		'status' => Status::ACTIVE,
	]);
	$admin->attachRole(Nova\Authorize\Role::name('System Admin')->first());
	$admin->attachRole(Nova\Authorize\Role::name('Active User')->first());

	// Create a user with the Active User role
	$user = factory('Nova\Users\User')->create([
		'name' => "Ben Doe",
		'email' => "user@example.com",
		'remember_token' => null,
		'status' => Status::ACTIVE,
	]);
	$user->attachRole(Nova\Authorize\Role::name('Active User')->first());
	
	$this->info('Created test users.');
});
