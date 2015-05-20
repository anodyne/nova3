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
	function flash($level = false, $content = false, $header = false)
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

if ( ! function_exists('flash_error'))
{
	function flash_error($message, $header = false)
	{
		return Flash::error($message, $header);
	}
}

if ( ! function_exists('flash_info'))
{
	function flash_info($message, $header = false)
	{
		return Flash::info($message, $header);
	}
}

if ( ! function_exists('flash_success'))
{
	function flash_success($message, $header = false)
	{
		return Flash::success($message, $header);
	}
}

if ( ! function_exists('flash_warning'))
{
	function flash_warning($message, $header = false)
	{
		return Flash::warning($message, $header);
	}
}

if ( ! function_exists('icon'))
{
	function icon($icon, $size = 'sm', $additional = false)
	{
		$iconCode = (Str::contains($icon, '.')) ? $icon : "nova.{$icon}";

		$icon = config("icons.{$iconCode}");

		return partial('icon', compact('icon', 'size', 'additional'));
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
		return view(Locate::partial($file), $data);
	}
}

if ( ! function_exists('checkDirectories'))
{
	function checkDirectories()
	{
		$directories = [
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

if ( ! function_exists('themePath'))
{
	function themePath($location = false, $relative = true)
	{
		if ($relative)
			return app()->themeRelativePath(app('nova.theme')->getLocation(true)."/{$location}");

		return app()->themePath(app('nova.theme')->getLocation(true)."/{$location}");
	}
}

if ( ! function_exists('locate'))
{
	function locate($type, $view)
	{
		return Locate::{$type}($view);
	}
}
