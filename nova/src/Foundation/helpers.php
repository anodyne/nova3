<?php

if ( ! function_exists('alert'))
{
	function alert($level, $content)
	{
		return partial('alert', compact('level', 'content'));
	}
}

if ( ! function_exists('flash'))
{
	function flash($level = false, $content = false)
	{
		$level = ( ! Session::has('flash.level')) ? $level : Session::get('flash.level');
		$content = ( ! Session::has('flash.message')) ? $content : Session::get('flash.message');

		return partial('flash', compact('level', 'content'));
	}
}

if ( ! function_exists('icon'))
{
	function icon($icon)
	{
		return partial('icon', compact('icon'));
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
			storage_path('logs'),
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