<?php namespace Nova\Api;

use App,
	Route,
	Config,
	Request,
	Response;
use Nova\Api\Auth\SentryAuth;
use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentry\Throttling\UserBannedException,
	Cartalyst\Sentry\Throttling\UserSuspendedException,
	Cartalyst\Sentry\Users\LoginRequiredException,
	Cartalyst\Sentry\Users\PasswordRequiredException,
	Cartalyst\Sentry\Users\UserNotFoundException;

class ApiServiceProvider extends ServiceProvider {

	public function register()
	{
		//
	}

	public function boot()
	{
		$this->setupAuthFilter();
		$this->registerV1Routes();
	}

	protected function setupAuthFilter()
	{
		$this->app['router']->filter('api.auth', function($route, $request)
		{
			$sentry = App::make('sentry');

			$login = $request->getUser();
			$password = $request->getPassword();

			try
			{
				if ((bool) $sentry->authenticate(compact('login', 'password')))
				{
					return Response::json(['message' => "Unauthorized"], 401);
				}
			}
			catch (UserBannedException $e)
			{
				return Response::json(['message' => "User is banned"], 401);
			}
			catch (UserSuspendedException $e)
			{
				return Response::json(['message' => "User is suspended"], 401);
			}
			catch (LoginRequiredException $e)
			{
				return Response::json(['message' => "Unauthorized"], 401);
			}
			catch (PasswordRequiredException $e)
			{
				return Response::json(['message' => "Unauthorized"], 401);
			}
			catch (UserNotFoundException $e)
			{
				return Response::json(['message' => "User not found"], 401);
			}
		});
	}

	protected function registerV1Routes()
	{
		Route::group(['prefix' => 'api/v1'], function()
		{
			/**
			 * API Info
			 *
			 * API Version
			 * Nova Version
			 * Nova Base URL
			 */
			Route::get('info', function()
			{
				return Response::json(['data' => [
					'api_version'	=> (string) Config::get('nova.api.version'),
					'nova_version'	=> (string) Config::get('nova.app.version'),
					'nova_url'		=> (string) str_replace(Request::path(), '', Request::url())
				]], 200);
			});

			/**
			 * User API
			 *
			 * GET		api/v1/users/{status}			Gets all users with the status
			 * GET		api/v1/users/{id}				Gets the user
			 * GET		api/v1/users/{id}/characters	Gets the user's characters
			 * GET		api/v1/users/{id}/image			Gets the user's image
			 * POST		api/v1/users					Create a new user
			 * PUT		api/v1/users/{id}				Update the user
			 * DELETE	api/v1/users/{id}				Delete the user
			 */
			Route::get('users/{status?}', 'Nova\Api\V1\Controllers\UsersController@index')
				->where('status', '[A-Za-z]+');
			Route::get('users/{id}', 'Nova\Api\V1\Controllers\UsersController@show')
				->where('id', '[0-9]+');
			Route::get('users/{id}/characters', 'Nova\Api\V1\Controllers\UsersController@showCharacters')
				->where('id', '[0-9]+');
			Route::get('users/{id}/image', 'Nova\Api\V1\Controllers\UsersController@showImage')
				->where('id', '[0-9]+');

			//Route::get('users/{type?}/page/{page?}', 'Nova\Api\V1\User@index')
				//->where('type', '[A-Za-z]+')
				//->where('page', '[0-9]+');
			//Route::get('users/{id}', 'Nova\Api\V1\User@show')->where('id', '[0-9]+');
			//Route::post('users', 'Nova\Api\V1\User@store');
			//Route::put('users/{id}', 'Nova\Api\V1\User@update');
			//Route::delete('users/{id}', 'Nova\Api\V1\User@destroy');
			//Route::get('users/{status?}', 'Nova\Api\V1\UsersController@index');
			//Route::put('users/{id}', 'Nova\Api\V1\UsersController@update');
			//Route::post('users', 'Nova\Api\V1\UsersController@store');
			//Route::delete('users/{id}', 'Nova\Api\V1\UsersController@destroy');
		});
	}

}