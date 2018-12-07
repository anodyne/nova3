<?php

namespace Nova\Foundation\Concerns;

use Status;
use Nova\Settings\Settings;

trait ProvidesScriptVariables
{
	public function scriptVariables()
	{
		// Grab the user so we can manually build the user object
		$currentUser = (nova()->isInstalled()) ? auth()->user() : null;

		// Nova's system variables
		$system = ['system' => [
			'version' => $this->version,
			'baseUrl' => app('request')->root(),
			'token' => csrf_token(),
			'genre' => config('nova.genre'),
			'timezone' => config('app.timezone'),
		]];

		// Nova's settings
		if (nova()->isInstalled()) {
			$settings = ['settings' => (array)app('nova.settings')];
		} else {
			$settings = ['settings' => [
				'rank' => (nova()->isInstalled()) ? Settings::item('rank')->first()->value : 'duty'
			]];
		}

		if ($currentUser) {
			$user = ['user' => [
				'name' => $currentUser->name,
				'email' => $currentUser->email,
			]];
		} else {
			$user = ['user' => [
				'name' => null,
				'email' => null,
			]];
		}

		// Nova's icons
		$icons = [
			'icons' => app('nova.theme')->iconMap()->toArray(),
			'iconTemplate' => app('nova.theme')->iconTemplate(),
		];

		// Nova's API options
		// $api = ['api' => config('nova.api')];

		// Nova's translation values
		$lang = ['lang' => app('nova.translator.messages')];

		// Nova's controller data
		$data = ['data' => (array) app('nova.response.data')];

		// Nova's statuses
		$statuses = ['status' => Status::all()];

		return collect(array_merge($system, $settings, $user, $icons, $lang, $data, $statuses));
	}

	protected function buildRoutesList()
	{
		$routes = [];

		foreach (app('router')->getRoutes() as $route) {
			$name = $route->getName();

			if ($name !== null) {
				$routes[$route->getName()] = $route->uri;
			}
		}

		return $routes;
	}
}
