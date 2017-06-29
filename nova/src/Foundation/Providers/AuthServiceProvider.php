<?php namespace Nova\Foundation\Providers;

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
	protected $policies = [
		'Nova\Authorize\Role' => 'Nova\Authorize\Policies\RolePolicy',
		'Nova\Authorize\Permission' => 'Nova\Authorize\Policies\PermissionPolicy',
		'Nova\Users\User' => 'Nova\Users\Policies\UserPolicy',
	];

	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->registerPolicies();

		// Grab all of the permissions, loop through them, and define the abilities
		Permission::with('roles')->get()->each(function ($permission) {
			Gate::define($permission->key, function ($user) use ($permission) {
				return $user->hasRole($permission->roles);
			});
		});
	}
}
