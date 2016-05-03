<?php

use Nova\Foundation\Themes\Theme as BaseTheme;

class Theme extends BaseTheme {

	public function getIconMap(): array
	{
		return [
			'add'			=> 'add',
			'announcement'	=> 'mic',
			'archive'		=> 'archive',
			'arrow-back'	=> 'arrow_back',
			'arrow-down'	=> 'arrow_downward',
			'arrow-forward'	=> 'arrow_forward',
			'arrow-up'		=> 'arrow_upward',
			'ban'			=> 'block',
			'bookmark'		=> 'bookmark',
			'brush'			=> 'brush',
			'check'			=> 'check',
			'clock'			=> 'schedule',
			'close'			=> 'clear',
			'code'			=> 'code',
			'comment'		=> 'chat_bubble',
			'comments'		=> 'forum',
			'copy'			=> 'content_copy',
			'cut'			=> 'content_cut',
			'dashboard'		=> 'dashboard',
			'delete'		=> 'delete',
			'edit'			=> 'edit',
			'file'			=> 'insert_drive_file',
			'flag'			=> 'flag',
			'forward'		=> 'forward',
			'heart'			=> 'favorite',
			'heart-empty'	=> 'favorite_border',
			'home'			=> 'home',
			'image'			=> 'image',
			'inbox'			=> 'inbox',
			'info'			=> 'info',
			'leaf'			=> 'nature',
			'light'			=> 'lightbulb_outline',
			'link'			=> 'link',
			'list'			=> 'list',
			'location'		=> 'location_on',
			'lock'			=> 'lock',
			'more'			=> 'more_horiz',
			'notifications'	=> 'notifications',
			'paste'			=> 'content_paste',
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
			'star-empty'	=> 'star_border',
			'tag'			=> 'label',
			'tasks'			=> 'playlist_add_check',
			'thumbs-down'	=> 'thumb_down',
			'thumbs-up'		=> 'thumb_up',
			'unlock'		=> 'lock_open',
			'user'			=> 'person',
			'users'			=> 'people',
			'warning'		=> 'warning',
		];
	}

	public function iconTemplate()
	{
		return '<i class="material-icons %classes%">%icon%</i>';
	}

}
