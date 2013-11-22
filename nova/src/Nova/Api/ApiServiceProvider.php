<?php namespace Nova\Api;

use App;
use Route;
use Config;
use Request;
use Response;
use Nova\Api\Auth\SentryAuth;
use Illuminate\Support\ServiceProvider;

use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserNotFoundException;

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
				return Response::json([
					'api_version'	=> Config::get('nova.api.version'),
					'nova_version'	=> Config::get('nova.app.version'),
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
			Route::get('users/{type?}', 'Nova\Api\V1\User@index')
				->where('type', '[A-Za-z]+');
			Route::get('users/{type?}/page/{page?}', 'Nova\Api\V1\User@index')
				->where('type', '[A-Za-z]+')
				->where('page', '[0-9]+');
			//Route::get('users/{id}', 'Nova\Api\V1\User@show')->where('id', '[0-9]+');
			Route::post('users', 'Nova\Api\V1\User@store');
			Route::put('users/{id}', 'Nova\Api\V1\User@update');
			Route::delete('users/{id}', 'Nova\Api\V1\User@destroy');

			//Route::get('users/{status?}', 'Nova\Api\V1\UsersController@index');
			Route::get('users/{id}', 'Nova\Api\V1\UsersController@show');
			//Route::get('users/{id}/image', 'Nova\Api\V1\UsersController@showImage');
			//Route::get('users/{id}/characters', 'Nova\Api\V1\UsersController@showCharacters');
			//Route::put('users/{id}', 'Nova\Api\V1\UsersController@update');
			//Route::post('users', 'Nova\Api\V1\UsersController@store');
			//Route::delete('users/{id}', 'Nova\Api\V1\UsersController@destroy');
		});
	}

}