<?php

use Nova\Foundation\Themes\Theme as BaseTheme;

class Theme extends BaseTheme {

	public function getIconMap(): array
	{
		return [
			'add'			=> 'plus2',
			'announcement'	=> 'bullhorn',
			'archive'		=> 'box',
			'arrow-back'	=> 'circle-left4',
			'arrow-down'	=> 'circle-down4',
			'arrow-forward'	=> 'circle-right4',
			'arrow-up'		=> 'circle-up4',
			'ban'			=> 'blocked',
			'bookmark'		=> 'bookmark2',
			'brush'			=> 'brush',
			'check'			=> 'checkmark4',
			'clock'			=> 'clock3',
			'close'			=> 'cross2',
			'code'			=> 'embed2',
			'comment'		=> 'bubble',
			'comments'		=> 'bubbles2',
			'copy'			=> 'copy3',
			'cut'			=> 'scissors3',
			'dashboard'		=> 'meter3',
			'delete'		=> 'bin2',
			'edit'			=> 'pencil',
			'file'			=> 'file-empty',
			'flag'			=> 'flag5',
			'forward'		=> 'forward',
			'heart'			=> 'heart3',
			'heart-empty'	=> 'heart4',
			'home'			=> 'home2',
			'image'			=> 'image',
			'inbox'			=> 'drawer2',
			'info'			=> 'info2',
			'leaf'			=> 'leaf',
			'light'			=> 'lamp8',
			'link'			=> 'link',
			'list'			=> 'list2',
			'location'		=> 'location',
			'lock'			=> 'lock5',
			'more'			=> 'menu',
			'notifications'	=> 'bell2',
			'paste'			=> 'copy',
			'question'		=> 'question4',
			'refresh'		=> 'loop3',
			'reply'			=> 'reply',
			'reply-all'		=> 'reply-all',
			'search'		=> 'search3',
			'send'			=> 'paperplane',
			'setting'		=> 'cog2',
			'share'			=> 'share3',
			'sign-in'		=> 'enter',
			'sign-out'		=> 'exit',
			'star'			=> 'star-full2',
			'star-empty'	=> 'star-empty3',
			'tag'			=> 'price-tag2',
			'tasks'			=> 'import',
			'thumbs-down'	=> 'thumbs-down3',
			'thumbs-up'		=> 'thumbs-up3',
			'unlock'		=> 'unlocked2',
			'user'			=> 'user',
			'users'			=> 'users',
			'warning'		=> 'warning2',
		];
	}

	public function iconTemplate(): string
	{
		return '<i class="icomoon-%icon% %classes%"></i>';
	}

}
