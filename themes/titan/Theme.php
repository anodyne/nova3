<?php

use Nova\Foundation\Themes\Theme as BaseTheme;

class Theme extends BaseTheme {

	public $iconTemplate = '<i class="entypo-%1$s %2$s"></i>';

	public function iconMap(): array
	{
		return [
			'add'			=> 'squared-plus',
			'announcement'	=> 'megaphone',
			'archive'		=> 'box',
			'arrow-back'	=> 'arrow-with-circle-left',
			'arrow-down'	=> 'arrow-with-circle-down',
			'arrow-forward'	=> 'arrow-with-circle-right',
			'arrow-up'		=> 'arrow-with-circle-up',
			'ban'			=> 'block',
			'bookmark'		=> 'bookmark',
			'brush'			=> 'brush',
			'check'			=> 'check',
			'clock'			=> 'clock',
			'close'			=> 'cross',
			'code'			=> 'code',
			'comment'		=> 'message',
			'comments'		=> 'chat',
			'copy'			=> 'copy',
			'dashboard'		=> 'gauge',
			'delete'		=> 'trash',
			'edit'			=> 'pencil',
			'file'			=> 'text-document-inverted',
			'flag'			=> 'flag',
			'forward'		=> 'forward',
			'heart'			=> 'heart',
			'heart-empty'	=> 'heart-outlined',
			'home'			=> 'home',
			'image'			=> 'image-inverted',
			'inbox'			=> 'inbox',
			'info'			=> 'info-with-circle',
			'leaf'			=> 'leaf',
			'light'			=> 'light-bulb',
			'link'			=> 'link',
			'list'			=> 'list',
			'location'		=> 'location-pin',
			'lock'			=> 'lock',
			'more'			=> 'dots-three-horizontal',
			'notifications'	=> 'bell',
			'paste'			=> 'clipboard',
			'question'		=> 'help-with-circle',
			'refresh'		=> 'cycle',
			'reply'			=> 'reply',
			'reply-all'		=> 'reply-all',
			'search'		=> 'magnifying-glass',
			'send'			=> 'paper-plane',
			'settings'		=> 'cog',
			'share'			=> 'share',
			'sign-in'		=> 'login',
			'sign-out'		=> 'log-out',
			'star'			=> 'star',
			'star-empty'	=> 'star-outlined',
			'tag'			=> 'price-tag',
			'tasks'			=> 'add-to-list',
			'thumbs-down'	=> 'thumbs-down',
			'thumbs-up'		=> 'thumbs-up',
			'unlock'		=> 'lock-open',
			'user'			=> 'user',
			'users'			=> 'users',
			'warning'		=> 'warning',
		];
	}
}
