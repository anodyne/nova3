<?php

use Nova\Foundation\Services\Themes\Theme as BaseTheme;

class Theme extends BaseTheme {

	public function getIconMap()
	{
		return [
			'add'			=> 'add',
			'announcement'	=> 'mic',
			'ban'			=> 'block',
			'bookmark'		=> 'bookmark',
			'check'			=> 'check',
			'clock'			=> 'schedule',
			'close'			=> 'clear',
			'comment'		=> 'chat_bubble',
			'comments'		=> 'forum',
			'dashboard'		=> 'dashboard',
			'delete'		=> 'delete',
			'edit'			=> 'edit',
			'file'			=> 'insert_drive_file',
			'forward'		=> 'forward',
			'heart'			=> 'favorite',
			'home'			=> 'home',
			'image'			=> 'image',
			'inbox'			=> 'inbox',
			'info'			=> 'info',
			'lock'			=> 'lock',
			'more'			=> 'more_horiz',
			'notifications'	=> 'notifications',
			'question'		=> 'help',
			'refresh'		=> 'autorenew',
			'reply'			=> 'reply',
			'reply-all'		=> 'reply_all',
			'search'		=> 'search',
			'send'			=> 'send',
			'setting'		=> 'settings',
			'share'			=> 'share',
			'sign-in'		=> 'power_settings_new',
			'sign-out'		=> 'power_settings_new',
			'star'			=> 'star',
			'tag'			=> 'tag',
			'tags'			=> 'fa fa-tags',
			'tasks'			=> 'playlist_add_check',
			'thumbs-down'	=> 'thumb_down',
			'thumbs-up'		=> 'thumb_up',
			'user'			=> 'person',
			'users'			=> 'people',
			'warning'		=> 'warning',
		];
	}

}
