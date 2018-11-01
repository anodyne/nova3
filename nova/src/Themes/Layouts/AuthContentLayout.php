<?php

namespace Nova\Themes\Layouts;

class AuthContentLayout extends Layout
{
	protected $key = 'auth-content';
	protected $name = 'Content';
	protected $image = 'layout-auth-content.svg';
	protected $section = 'auth';
	protected $options = [
		'subtitle' => [
			'type' => 'text',
			'label' => 'Subtitle',
		],
		'content' => [
			'type' => 'text',
			'label' => 'Your Content',
		],
	];
}
