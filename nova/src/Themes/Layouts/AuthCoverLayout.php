<?php

namespace Nova\Themes\Layouts;

class AuthCoverLayout extends Layout
{
	protected $key = 'auth-cover';
	protected $name = 'Cover';
	protected $image = 'layout-auth-cover.svg';
	protected $section = 'auth';
	protected $options = [
		'subtitle' => [
			'type' => 'text',
			'label' => 'Subtitle',
		],
		'cover-image' => [
			'type' => 'image',
			'label' => 'Cover Image',
			'help' => 'Select an image that will be big enough to cover the entire height of the screen on a variety of display resolutions.'
		]
	];
}
