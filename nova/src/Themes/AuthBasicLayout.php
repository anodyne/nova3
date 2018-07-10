<?php

namespace Nova\Themes;

class AuthBasicLayout extends Layout
{
	protected $key = 'auth-basic';
	protected $name = 'Basic';
	protected $image = 'layout-auth-basic.svg';
	protected $section = 'auth';
	protected $options = [
		'subtitle' => [
			'type' => 'text'
		]
	];
}
