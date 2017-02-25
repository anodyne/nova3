<?php namespace Nova\Foundation\Themes;

use Str;
use Illuminate\Support\Collection;

trait ThemeIcons {

	public $iconTemplate = '<i class="fa fa-%1$s %2$s fa-fw"></i>';

	public function buildIconList($extraClasses = false): array
	{
		$self = $this;

		return $this->getIconMap()->map(function ($icon, $key) use ($self, $extraClasses) {
			$preview = $self->renderIcon($icon, $extraClasses);

			return compact('key', 'icon', 'preview');
		})->all();
	}
	
	public function getIcon($icon)
	{
		return $this->getIconMap()->get($icon);
	}

	public function getIconMap()
	{
		$self = $this;

		return collect($this->iconMap())->map(function ($icon, $key) use ($self) {
			return $icon;
		});
	}
	
	public function iconMap(): array
	{
		return [
			'add'				=> 'plus',
			'android'			=> 'android',
			'announcement'		=> 'bullhorn',
			'apple'				=> 'apple',
			'archive'			=> 'archive',
			'arrow-down'		=> 'arrow-down',
			'arrow-left'		=> 'arrow-left',
			'arrow-right'		=> 'arrow-right',
			'arrow-up'			=> 'arrow-up',
			'ban'				=> 'ban',
			'bell'				=> 'bell',
			'bell-outline'		=> 'bell-o',
			'bolt'				=> 'bolt',
			'book'				=> 'book',
			'bookmark'			=> 'bookmark',
			'briefcase'			=> 'briefcase',
			'browser-chrome'	=> 'chrome',
			'browser-edge'		=> 'edge',
			'browser-firefox'	=> 'firefox',
			'browser-ie'		=> 'internet-explorer',
			'browser-safari'	=> 'safari',
			'calendar'			=> 'calendar-o',
			'caret-down'		=> 'caret-down',
			'caret-up'			=> 'caret-up',
			'chart-area'		=> 'area-chart',
			'chart-bar'			=> 'bar-chart',
			'chart-line'		=> 'line-chart',
			'chart-pie'			=> 'pie-chart',
			'check'				=> 'check',
			'clock'				=> 'clock-o',
			'clone'				=> 'clone',
			'close'				=> 'close',
			'cloud'				=> 'cloud',
			'cloud-download'	=> 'cloud-download',
			'cloud-upload'		=> 'cloud-upload',
			'code'				=> 'code',
			'comment'			=> 'comment',
			'comments'			=> 'comments',
			'dashboard'			=> 'dashboard',
			'delete'			=> 'trash',
			'device-desktop'	=> 'desktop',
			'device-laptop'		=> 'laptop',
			'device-mobile'		=> 'mobile',
			'device-tablet'		=> 'tablet',
			'download'			=> 'download',
			'edit'				=> 'pencil',
			'email'				=> 'envelope',
			'hide'				=> 'eye-slash',
			'face-frown'		=> 'frown-o',
			'face-meh'			=> 'meh-o',
			'face-smile'		=> 'smile-o',
			'facebook'			=> 'facebook-square',
			'file'				=> 'file-o',
			'file-text'			=> 'file-text-o',
			'fire'				=> 'fire',
			'flag'				=> 'flag',
			'folder'			=> 'folder',
			'folder-open'		=> 'folder-open',
			'forward'			=> 'mail-forward',
			'gift'				=> 'gift',
			'google'			=> 'google',
			'heart'				=> 'heart',
			'heart-empty'		=> 'heart-o',
			'history'			=> 'history',
			'home'				=> 'home',
			'image'				=> 'image',
			'inbox'				=> 'inbox',
			'info'				=> 'info-circle',
			'key'				=> 'key',
			'leaf'				=> 'leaf',
			'lightbulb'			=> 'lightbulb-o',
			'link'				=> 'chain',
			'linux'				=> 'linux',
			'list'				=> 'th-list',
			'lock'				=> 'lock',
			'magic'				=> 'magic',
			'map-marker'		=> 'map-marker',
			'map-signs'			=> 'map-signs',
			'more-horizontal'	=> 'ellipsis-h',
			'more-vertical'		=> 'ellipsis-v',
			'paint-brush'		=> 'paint-brush',
			'paper-plane'		=> 'paper-plane',
			'paper-plane-alt'	=> 'paper-plane-o',
			'question'			=> 'question-circle',
			'refresh'			=> 'refresh',
			'reply'				=> 'mail-reply',
			'reply-all'			=> 'mail-reply-all',
			'search'			=> 'search',
			'share'				=> 'share-alt',
			'shield'			=> 'shield',
			'setting'			=> 'cog',
			'settings'			=> 'cogs',
			'settings-alt'		=> 'sliders',
			'show'				=> 'eye',
			'sign-in'			=> 'sign-in',
			'sign-out'			=> 'sign-out',
			'sort-alpha-asc'	=> 'sort-alpha-asc',
			'sort-alpha-desc'	=> 'sort-alpha-desc',
			'sort-amount-asc'	=> 'sort-amount-asc',
			'sort-amount-desc'	=> 'sort-amount-desc',
			'sort-numeric-asc'	=> 'sort-numeric-asc',
			'sort-numeric-desc'	=> 'sort-numeric-desc',
			'star'				=> 'star',
			'star-empty'		=> 'star-o',
			'support'			=> 'life-bouy',
			'tag'				=> 'tag',
			'tags'				=> 'tags',
			'tasks'				=> 'tasks',
			'thumbs-down'		=> 'thumbs-o-down',
			'thumbs-up'			=> 'thumbs-o-up',
			'ticket'			=> 'ticket',
			'trophy'			=> 'trophy',
			'twitter'			=> 'twitter',
			'unlock'			=> 'unlock-alt',
			'upload'			=> 'upload',
			'user'				=> 'user',
			'user-card'			=> 'drivers-license-o',
			'user-circle'		=> 'user-circle-o',
			'users'				=> 'group',
			'warning'			=> 'exclamation-triangle',
			'windows'			=> 'windows',
			'wrench'			=> 'wrench',
		];
	}
	
	public function renderIcon($icon, $extraClasses = false)
	{
		if (Str::contains($icon, '.svg'))
		{
			return $this->renderSvgIcon(locate()->svg($icon), $extraClasses);
		}

		if (strrpos($icon, '.'))
		{
			return $this->renderImageIcon(locate()->image($icon), $extraClasses);
		}

		return $this->renderFontIcon($icon, $extraClasses);
	}

	public function renderImageIcon($icon, $extraClasses = false)
	{
		return app('html')->image($icon, $extraClasses);
	}

	public function renderFontIcon($icon, $extraClasses = false)
	{
		return sprintf($this->iconTemplate, $icon, $extraClasses);
	}

	public function renderSvgIcon($icon, $extraClasses = false)
	{
		return svg_icon($icon, $extraClasses)->toHtml();
	}
}
