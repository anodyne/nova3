<?php namespace Nova\Api;

use Request;
use Response;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->registerV1Routes();
	}

	protected function registerV1Routes()
	{
		$this->app['router']->group(['prefix' => 'api/v1'], function()
		{
			/**
			 * API Info
			 *
			 * API Version
			 * Nova Version
			 * Nova Base URL
			 */
			$this->app['router']->get('info', function()
			{
				return Response::api([
					'api_version'	=> $this->app['config']->get('nova.api.version'),
					'nova_version'	=> $this->app['config']->get('nova.app.version'),
					'nova_url'		=> str_replace(Request::path(), '', Request::url())
				], 200);
			});

			/**
			 * User API
			 *
			 * GET		api/v1/user/{type}/{page}	Gets all users with the type specified
			 * GET		api/v1/user/{id}			Gets the user with the matching ID
			 * POST		api/v1/user					Create a new user
			 * PUT		api/v1/user/{id}			Update the user passed in the URI
			 * DELETE	api/v1/user/{id}			Delete the user passed in the URI
			 */
			$this->app['router']->get('user/{type?}', 'Nova\Api\V1\User@index')
				->where('type', '[A-Za-z]+');
			$this->app['router']->get('user/{type?}/page/{page?}', 'Nova\Api\V1\User@index')
				->where('type', '[A-Za-z]+')
				->where('page', '[0-9]+');
			$this->app['router']->get('user/{id}', 'Nova\Api\V1\User@show')
				->where('id', '[0-9]+');
			$this->app['router']->post('user', 'Nova\Api\V1\User@store');
			$this->app['router']->put('user/{id}', 'Nova\Api\V1\User@update');
			$this->app['router']->delete('user/{id}', 'Nova\Api\V1\User@destroy');
		});
	}

}