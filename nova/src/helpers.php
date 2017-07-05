<?php

if (! function_exists('_m')) {
	function _m($key, $args = [])
	{
		//$gender = (user()) ? user()->gender : 'male';
		$gender = 'male';

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

if (! function_exists('creator')) {
	function creator($model)
	{
		return app(config('maps.creators')[$model]);
	}
}

if (! function_exists('d')) {
	function d()
	{
		array_map(function ($x) {
			(new Illuminate\Support\Debug\Dumper)->dump($x);
		}, func_get_args());
	}
}

if (! function_exists('flash')) {
	function flash()
	{
		return app('nova.flash');
	}
}

if (! function_exists('icon')) {
	function icon($icon, $additional = false)
	{
		return app('nova.theme')->renderIcon($icon, $additional);
	}
}

if (! function_exists('updater')) {
	function updater($model)
	{
		return app(config('maps.updaters')[$model]);
	}
}
