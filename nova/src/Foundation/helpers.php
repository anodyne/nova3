<?php

use Illuminate\Support\Debug\Dumper;

if ( ! function_exists('alert'))
{
	function alert($level, $content, $header = false)
	{
		$content = Markdown::parse($content);

		return partial('alert', compact('level', 'content', 'header'));
	}
}

if ( ! function_exists('d'))
{
	function d()
	{
		array_map(function($x) { (new Dumper)->dump($x); }, func_get_args());
	}
}

if ( ! function_exists('flash'))
{
	function flash($level = false, $title = false, $message = false)
	{
		// Get the instance of the flash notifier service
		$flash = app('nova.flash');

		// If we don't pass anything, just return the instance
		if ( ! $level) return $flash;

		// Use the level to create the flash message
		$flash->{$level}($title, $message);
	}
}

if ( ! function_exists('display_flash_message'))
{
	function display_flash_message($level = false, $content = false, $header = false)
	{
		if (Session::has('flash.message'))
		{
			$level = ( ! Session::has('flash.level')) ? $level : Session::get('flash.level');
			$content = ( ! Session::has('flash.message')) ? $content : Session::get('flash.message');
			$header = ( ! Session::has('flash.header')) ? $header : Session::get('flash.header');

			return partial('flash', compact('level', 'content', 'header'));
		}
	}
}

if ( ! function_exists('icon'))
{
	function icon($icon, $size = 'sm', $additional = false)
	{
		$iconCode = (Str::contains($icon, '.')) ? $icon : "nova.{$icon}";

		// Get the icon item out of the config array
		$iconItem = config("icons.{$iconCode}");

		// Parse out the pieces we need
		$type = $iconItem['type'];
		$icon = $iconItem['value'];

		return partial('icon', compact('icon', 'size', 'additional', 'type'));
	}
}

if ( ! function_exists('label'))
{
	function label($type, $content)
	{
		return partial('label', compact('type', 'content'));
	}
}

if ( ! function_exists('modal'))
{
	function modal(array $data)
	{
		return partial('modal', [
			'id'		=> (array_key_exists('id', $data)) ? $data['id'] : false,
			'header'	=> (array_key_exists('header', $data)) ? $data['header'] : false,
			'body'		=> (array_key_exists('body', $data)) ? $data['body'] : false,
			'footer'	=> (array_key_exists('footer', $data)) ? $data['footer'] : false,
		]);
	}
}

if ( ! function_exists('nova_path'))
{
	function nova_path($path = '')
	{
		return app('path.nova').($path ? '/'.$path : $path);
	}
}

if ( ! function_exists('partial'))
{
	function partial($file, array $data = [])
	{
		return view(locate()->partial($file), $data)->render();
	}
}

if ( ! function_exists('check_directories'))
{
	function check_directories()
	{
		$directories = [
			nova_path('bootstrap/cache'),
			storage_path('framework'),
			storage_path('framework/views'),
		];

		foreach ($directories as $dir)
		{
			if ( ! is_writable($dir))
			{
				dd("The [$dir] directory must be writable in order to continue. Please set permissions on the directory to 777.");
			}
		}
	}
}

if ( ! function_exists('theme_path'))
{
	function theme_path($location = false, $relative = true)
	{
		if ($relative)
		{
			return app()->themeRelativePath(app('nova.theme')->getLocation(true)."/{$location}");
		}

		return app()->themePath(app('nova.theme')->getLocation(true)."/{$location}");
	}
}

if ( ! function_exists('locate'))
{
	function locate($type = false, $view = false)
	{
		// Get an instance of the locator
		$locator = app('nova.locator');

		if ( ! $type) return $locator;

		return $locator->{$type}($view);
	}
}

if ( ! function_exists('user'))
{
	function user()
	{
		return app('nova.user');
	}
}
