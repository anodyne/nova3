<?php

use Illuminate\Foundation\Inspiring;

Artisan::command('inspire', function () {
	$this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('nova:refresh', function () {
	// Flush the caches
	Cache::flush();
	Session::flush();
	Artisan::call('config:clear');
	Artisan::call('route:clear');
	$this->info('Cleared system caches.');

	// Refresh the migrations
	Artisan::call('migrate:refresh', ['--force' => true]);
	$this->info('Refreshed database.');

	// Create a user with the System Admin role
	$admin = factory('Nova\Users\User')->create([
		'name' => "David",
		'email' => "david.vanscott@gmail.com",
		'remember_token' => null,
		'status' => Status::ACTIVE,
	]);
	$admin->attachRole(Nova\Authorize\Role::name('System Admin')->first());
	$admin->attachRole(Nova\Authorize\Role::name('Active User')->first());
	$this->info('Created user with the System Admin and Active User roles.');
});

Artisan::command('nova:refresh-demo', function () {
	// Flush the caches
	Cache::flush();
	Session::flush();
	Artisan::call('config:clear');
	Artisan::call('route:clear');
	$this->info('Cleared system caches.');

	// Refresh the migrations
	Artisan::call('migrate:refresh', ['--force' => true]);
	$this->info('Refreshed database.');

	// Create a user with the System Admin role
	$admin = factory('Nova\Users\User')->create([
		'name' => "John Admin",
		'email' => "admin@example.com",
		'remember_token' => null,
		'status' => Status::ACTIVE,
	]);
	$admin->attachRole(Nova\Authorize\Role::name('System Admin')->first());
	$admin->attachRole(Nova\Authorize\Role::name('Active User')->first());
	$this->info('Created user with the System Admin and Active User roles.');

	// Create a user with the Active User role
	$active = factory('Nova\Users\User')->create([
		'name' => "Susie User",
		'email' => 'user@example.com',
		'remember_token' => null,
		'status' => Status::ACTIVE,
	]);
	$active->attachRole(Nova\Authorize\Role::name('Active User')->first());
	$this->info('Created user with the Active User role.');
});
