<?php namespace Nova\Foundation\Themes;

use Str;
use Illuminate\Support\Collection;

trait ThemeIcons {

	public $iconTemplate = '<i class="fa fa-%1$s %2$s"></i>';

	public function buildIconList($extraClasses = false): array
	{
		$self = $this;

		return $this->getIconMap()->map(function ($icon, $key) use ($self, $extraClasses)
		{
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
			'add'			=> 'plus',
			'announcement'	=> 'bullhorn',
			'archive'		=> 'archive',
			'arrow-back'	=> 'arrow-left',
			'arrow-down'	=> 'arrow-down',
			'arrow-forward'	=> 'arrow-right',
			'arrow-up'		=> 'arrow-up',
			'ban'			=> 'ban',
			'bolt'			=> 'bolt',
			'book'			=> 'book',
			'bookmark'		=> 'bookmark',
			'briefcase'		=> 'briefcase',
			'brush'			=> 'paint-brush',
			'calendar'		=> 'calendar-o',
			'caret-down'	=> 'caret-down',
			'caret-up'		=> 'caret-up',
			'chart-area'	=> 'area-chart',
			'chart-bar'		=> 'bar-chart',
			'chart-line'	=> 'line-chart',
			'chart-pie'		=> 'pie-chart',
			'check'			=> 'check',
			'clock'			=> 'clock-o',
			'close'			=> 'times',
			'cloud'			=> 'cloud',
			'cloud-download'=> 'cloud-download',
			'cloud-upload'	=> 'cloud-upload',
			'code'			=> 'code',
			'comment'		=> 'comment',
			'comments'		=> 'comments',
			'copy'			=> 'clone',
			'cut'			=> 'scissors',
			'dashboard'		=> 'tachometer',
			'delete'		=> 'trash',
			'desktop'		=> 'desktop',
			'directions'	=> 'map-signs',
			'download'		=> 'download',
			'edit'			=> 'pencil',
			'email'			=> 'envelope',
			'file'			=> 'file-o',
			'fire'			=> 'fire',
			'flag'			=> 'flag',
			'folder'		=> 'folder',
			'folder-open'	=> 'folder-open',
			'forward'		=> 'share',
			'frown'			=> 'frown-o',
			'gift'			=> 'gift',
			'heart'			=> 'heart',
			'heart-empty'	=> 'heart-o',
			'history'		=> 'history',
			'home'			=> 'home',
			'image'			=> 'image',
			'inbox'			=> 'inbox',
			'info'			=> 'info-circle',
			'key'			=> 'key',
			'laptop'		=> 'laptop',
			'leaf'			=> 'leaf',
			'light'			=> 'lightbulb-o',
			'link'			=> 'link',
			'list'			=> 'list-ul',
			'location'		=> 'map-marker',
			'lock'			=> 'lock',
			'mobile'		=> 'mobile',
			'more'			=> 'ellipsis-h',
			'not-visible'	=> 'eye-slash',
			'notifications'	=> 'bell',
			'paste'			=> 'clipboard',
			'question'		=> 'question',
			'refresh'		=> 'refresh',
			'reply'			=> 'reply',
			'reply-all'		=> 'reply-all',
			'search'		=> 'search',
			'send'			=> 'paper-plane',
			'settings'		=> 'cog',
			'share'			=> 'share-alt',
			'shield'		=> 'shield',
			'sign-in'		=> 'sign-in',
			'sign-out'		=> 'sign-out',
			'smile'			=> 'smile-o',
			'star'			=> 'star',
			'star-empty'	=> 'star-o',
			'tablet'		=> 'tablet',
			'tag'			=> 'tag',
			'tasks'			=> 'tasks',
			'thumbs-down'	=> 'thumbs-down',
			'thumbs-up'		=> 'thumbs-up',
			'ticket'		=> 'ticket',
			'trophy'		=> 'trophy',
			'unlock'		=> 'unlock',
			'upload'		=> 'upload',
			'user'			=> 'user',
			'users'			=> 'users',
			'visible'		=> 'eye',
			'warning'		=> 'exclamation-triangle',
			'wizard'		=> 'magic',
			'wrench'		=> 'wrench',
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
