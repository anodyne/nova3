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
	
	public function getIcon(string $icon)
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
			'add' => 'plus.svg', // Will go out and try to find an SVG with the name 'plus'
			'remove' => 'remove.png', // Will go out and try to find an image with the name 'remove.png'
			'edit' => 'pencil', // Will assume an icon font and will render the template you set
		];

		return [
			'add'			=> 'anodyne.svg',
			'announcement'	=> 'bullhorn.svg',
			'archive'		=> 'archive.svg',
			'arrow-back'	=> 'arrow-left.svg',
			'arrow-down'	=> 'arrow-down.svg',
			'arrow-forward'	=> 'arrow-right.svg',
			'arrow-up'		=> 'arrow-up.svg',
			'ban'			=> 'ban.svg',
			'bolt'			=> 'bolt.svg',
			'book'			=> 'book.svg',
			'bookmark'		=> 'bookmark.svg',
			'briefcase'		=> 'briefcase.svg',
			'brush'			=> 'paint-brush.svg',
			'calendar'		=> 'calendar-o.svg',
			'caret-down'	=> 'caret-down.svg',
			'caret-up'		=> 'caret-up.svg',
			'chart-area'	=> 'area-chart.svg',
			'chart-bar'		=> 'bar-chart.svg',
			'chart-line'	=> 'line-chart.svg',
			'chart-pie'		=> 'pie-chart.svg',
			'check'			=> 'check.svg',
			'clock'			=> 'clock-o.svg',
			'close'			=> 'times.svg',
			'cloud'			=> 'cloud.svg',
			'cloud-download'=> 'cloud-download.svg',
			'cloud-upload'	=> 'cloud-upload.svg',
			'code'			=> 'code.svg',
			'comment'		=> 'comment.svg',
			'comments'		=> 'comments.svg',
			'copy'			=> 'clone.svg',
			'cut'			=> 'scissors.svg',
			'dashboard'		=> 'tachometer.svg',
			'delete'		=> 'trash.svg',
			'desktop'		=> 'desktop.svg',
			'directions'	=> 'map-signs.svg',
			'download'		=> 'download.svg',
			'edit'			=> 'pencil.svg',
			'email'			=> 'envelope.svg',
			'file'			=> 'file-o.svg',
			'fire'			=> 'fire.svg',
			'flag'			=> 'flag.svg',
			'folder'		=> 'folder.svg',
			'folder-open'	=> 'folder-open.svg',
			'forward'		=> 'share.svg',
			'frown'			=> 'frown-o.svg',
			'gift'			=> 'gift.svg',
			'heart'			=> 'heart.svg',
			'heart-empty'	=> 'heart-o.svg',
			'history'		=> 'history.svg',
			'home'			=> 'home.svg',
			'image'			=> 'image.svg',
			'inbox'			=> 'inbox.svg',
			'info'			=> 'info-circle.svg',
			'key'			=> 'key.svg',
			'laptop'		=> 'laptop.svg',
			'leaf'			=> 'leaf.svg',
			'light'			=> 'lightbulb-o.svg',
			'link'			=> 'link.svg',
			'list'			=> 'list-ul.svg',
			'location'		=> 'map-marker.svg',
			'lock'			=> 'lock.svg',
			'mobile'		=> 'mobile.svg',
			'more'			=> 'ellipsis-h.svg',
			'not-visible'	=> 'eye-slash.svg',
			'notifications'	=> 'bell.svg',
			'paste'			=> 'clipboard.svg',
			'question'		=> 'question.svg',
			'refresh'		=> 'refresh.svg',
			'reply'			=> 'reply.svg',
			'reply-all'		=> 'reply-all.svg',
			'search'		=> 'search.svg',
			'send'			=> 'paper-plane.svg',
			'settings'		=> 'cog.svg',
			'share'			=> 'share-alt.svg',
			'shield'		=> 'shield.svg',
			'sign-in'		=> 'sign-in.svg',
			'sign-out'		=> 'sign-out.svg',
			'smile'			=> 'smile-o.svg',
			'star'			=> 'star.svg',
			'star-empty'	=> 'star-o.svg',
			'tablet'		=> 'tablet.svg',
			'tag'			=> 'tag.svg',
			'tasks'			=> 'tasks.svg',
			'thumbs-down'	=> 'thumbs-down.svg',
			'thumbs-up'		=> 'thumbs-up.svg',
			'ticket'		=> 'ticket.svg',
			'trophy'		=> 'trophy.svg',
			'unlock'		=> 'unlock.svg',
			'upload'		=> 'upload.svg',
			'user'			=> 'user.svg',
			'users'			=> 'users.svg',
			'visible'		=> 'eye.svg',
			'warning'		=> 'exclamation-triangle.svg',
			'wizard'		=> 'magic.svg',
			'wrench'		=> 'wrench.svg',
		];
	}
	
	public function renderIcon(string $icon, $extraClasses = false)
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

	public function renderImageIcon(string $icon, $extraClasses = false)
	{
		return app('html')->image($icon, $extraClasses);
	}

	public function renderFontIcon(string $icon, $extraClasses = false)
	{
		return sprintf($this->iconTemplate, $icon, $extraClasses);
	}

	public function renderSvgIcon(string $icon, $extraClasses = false)
	{
		return svg_icon($icon, $extraClasses)->toHtml();
	}
}
