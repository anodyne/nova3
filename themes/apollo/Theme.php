<?php

use Nova\Foundation\Themes\Theme as BaseTheme;

class Theme extends BaseTheme
{
	public $iconTemplate = '<i class="icomoon-%1$s %2$s"></i>';

	public function iconMap(): array
	{
		return [
			'add'				=> 'plus3',
			'android'			=> 'android',
			'announcement'		=> 'bullhorn',
			'apple'				=> 'appleinc',
			'archive'			=> 'box',
			'arrow-down'		=> 'arrow-down8',
			'arrow-left'		=> 'arrow-left8',
			'arrow-right'		=> 'arrow-right8',
			'arrow-up'			=> 'arrow-up8',
			'ban'				=> 'blocked',
			'bell'				=> 'bell2',
			'bell-outline'		=> 'bell2',
			'bolt'				=> 'power2',
			'book'				=> 'bookmark',
			'bookmark'			=> 'bookmark2',
			'briefcase'			=> 'briefcase',
			'browser-chrome'	=> 'chrome',
			'browser-edge'		=> 'edge',
			'browser-firefox'	=> 'firefox',
			'browser-ie'		=> 'IE',
			'browser-safari'	=> 'safari',
			'calendar'			=> 'calendar2',
			'caret-down'		=> 'arrow-down5',
			'caret-up'			=> 'arrow-up5',
			'chart-area'		=> 'chart',
			'chart-bar'			=> 'stats-bars2',
			'chart-line'		=> 'stats-dots',
			'chart-pie'			=> 'pie-chart7',
			'check'				=> 'checkmark4',
			'clock'				=> 'clock',
			'clone'				=> 'stack',
			'close'				=> 'cross3',
			'cloud'				=> 'cloud2',
			'cloud-download'	=> 'cloud-download2',
			'cloud-upload'		=> 'cloud-upload2',
			'code'				=> 'embed2',
			'comment'			=> 'bubble',
			'comments'			=> 'bubbles2',
			'dashboard'			=> 'meter-fast',
			'delete'			=> 'bin3',
			'device-desktop'	=> 'display',
			'device-laptop'		=> 'laptop',
			'device-mobile'		=> 'mobile',
			'device-tablet'		=> 'tablet',
			'download'			=> 'download',
			'edit'				=> 'pencil',
			'email'				=> 'envelop5',
			'hide'				=> 'eye-blocked3',
			'face-frown'		=> 'sad',
			'face-meh'			=> 'neutral',
			'face-smile'		=> 'smile',
			'facebook'			=> 'facebook2',
			'file'				=> 'file-empty2',
			'file-text'			=> 'file-text3',
			'fire'				=> 'fire',
			'flag'				=> 'flag5',
			'folder'			=> 'folder2',
			'folder-open'		=> 'folder-open',
			'forward'			=> 'forward',
			'gift'				=> 'gift2',
			'google'			=> 'google',
			'heart'				=> 'heart5',
			'heart-empty'		=> 'heart6',
			'history'			=> 'history',
			'home'				=> 'home5',
			'image'				=> 'image',
			'inbox'				=> 'drawer',
			'info'				=> 'info2',
			'key'				=> 'key',
			'leaf'				=> 'leaf',
			'lightbulb'			=> 'lamp8',
			'link'				=> 'link',
			'linux'				=> 'tux',
			'list'				=> 'list',
			'lock'				=> 'lock4',
			'magic'				=> 'magic-wand',
			'map-marker'		=> 'location',
			'map-signs'			=> 'direction',
			'more-horizontal'	=> 'menu',
			'more-vertical'		=> 'more2',
			'paint-brush'		=> 'brush',
			'paper-plane'		=> 'paperplane',
			'paper-plane-alt'	=> 'paperplane',
			'question'			=> 'question2',
			'refresh'			=> 'loop3',
			'reply'				=> 'reply',
			'reply-all'			=> 'reply-all',
			'search'			=> 'search3',
			'share'				=> 'share3',
			'shield'			=> 'shield2',
			'setting'			=> 'cog2',
			'settings'			=> 'cogs',
			'settings-alt'		=> 'equalizer',
			'show'				=> 'eye3',
			'sign-in'			=> 'enter3',
			'sign-out'			=> 'exit3',
			'sort-alpha-asc'	=> 'sort-alpha-asc',
			'sort-alpha-desc'	=> 'sort-alpha-desc',
			'sort-amount-asc'	=> 'sort-amount-asc',
			'sort-amount-desc'	=> 'sort-amount-desc',
			'sort-numeric-asc'	=> 'sort-numeric-asc',
			'sort-numeric-desc'	=> 'sort-numberic-desc',
			'star'				=> 'star-full2',
			'star-empty'		=> 'star-empty3',
			'support'			=> 'lifebuoy',
			'tag'				=> 'price-tag2',
			'tags'				=> 'price-tags',
			'tasks'				=> 'clipboard5',
			'thumbs-down'		=> 'thumbs-down3',
			'thumbs-up'			=> 'thumbs-up3',
			'ticket'			=> 'ticket',
			'trophy'			=> 'trophy2',
			'twitter'			=> 'twitter',
			'unlock'			=> 'unlocked',
			'upload'			=> 'upload',
			'user'				=> 'user6',
			'user-card'			=> 'vcard',
			'user-circle'		=> 'user6',
			'users'				=> 'users4',
			'warning'			=> 'warning2',
			'windows'			=> 'windows8',
			'wrench'			=> 'wrench',
		];
	}
}
