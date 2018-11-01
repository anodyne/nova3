<?php

if (! function_exists('_m')) {
	function _m($key, $args = [])
	{
		$gender = (auth()->check()) ? auth()->user()->gender : 'neutral';

		return app('nova.translator')->msg($key, [
			'parsemag' => true,
			'variables' => array_merge([$gender], $args)
		]);
	}
}

if (! function_exists('alias')) {
	function alias($name)
	{
		return config("app.aliases.{$name}");
	}
}

if (! function_exists('avatar')) {
	function avatar($user)
	{
		return app('nova.avatar')->setUser($user);
	}
}

if (! function_exists('carbon')) {
	function carbon($parseString, $tz = null)
	{
		return new Carbon\Carbon($parseString, $tz);
	}
}

if (! function_exists('creator')) {
	function creator($model)
	{
		return app(config('maps.creators')[$model]);
	}
}

if (! function_exists('d')) {
	function d()
	{
		array_map(function ($debug) {
			(new Symfony\Component\VarDumper\VarDumper)->dump($debug);
		}, func_get_args());
	}
}

if (! function_exists('deletor')) {
	function deletor($model)
	{
		return app(config('maps.deletors')[$model]);
	}
}

if (! function_exists('duplicator')) {
	function duplicator($model)
	{
		return app(config('maps.duplicators')[$model]);
	}
}

if (! function_exists('extension_path')) {
	function extension_path($identifier = false)
	{
		return app()->extensionPath($identifier);
	}
}

if (! function_exists('flash')) {
	function flash()
	{
		return app('nova.flash');
	}
}

if (! function_exists('hook')) {
	function hook($routeName, $callback)
	{
		return app('nova.hooks')->register($routeName, $callback);
	}
}

if (! function_exists('icon')) {
	function icon($icon, $additionalClasses = null)
	{
		return '<icon name="'.$icon.'" classes="'.$additionalClasses.'"></icon>';
	}
}

if (! function_exists('nova')) {
	function nova()
	{
		return app('nova');
	}
}

if (! function_exists('partial')) {
	function partial($view, array $data = [])
	{
		return view("components.partials.{$view}", $data);
	}
}

if (! function_exists('restorer')) {
	function restorer($model)
	{
		return app(config('maps.restorers')[$model]);
	}
}

if (! function_exists('setup_path')) {
	function setup_path($path = false)
	{
		return app()->path("Setup/{$path}");
	}
}

if (! function_exists('theme_path')) {
	function theme_path($identifier = false)
	{
		return app()->themePath($identifier);
	}
}

if (! function_exists('updater')) {
	function updater($model)
	{
		return app(config('maps.updaters')[$model]);
	}
}
