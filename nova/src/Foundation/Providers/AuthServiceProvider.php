<?php namespace Nova\Foundation\Providers;

use Laravel\Passport\Passport;
use Nova\Authorize\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->policies = config('maps.policies');

		$this->registerPolicies();

		Passport::routes();

		if (app()->environment() != 'testing') {
			$this->defineGates();
		}
	}

	public function defineGates()
	{
		// Grab all of the permissions
		$permissions = cache('nova.permissions');

		if ($permissions) {
			// Loop through them, and define the abilities
			$permissions->each(function ($permission) {
				Gate::define($permission->key, function ($user) use ($permission) {
					return $user->hasRole($permission->roles);
				});
			});
		}
	}
}
