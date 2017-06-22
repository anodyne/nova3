<?php namespace Nova\Foundation\Providers;

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

		//
	}
}
