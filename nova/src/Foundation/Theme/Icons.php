<?php namespace Nova\Foundation\Theme;

use Str;

trait Icons
{
	public $iconTemplate = '<i class="far fa-%1$s %2$s fa-fw"></i>';

	public function getIcon($icon)
	{
		return $this->iconMap()->get($icon);
	}

	public function iconMap()
	{
		return collect([
			'add' => 'plus',
			'add-alt' => 'plus-circle',
			'arrow-down' => 'arrow-circle-down',
			'arrow-left' => 'arrow-circle-left',
			'arrow-right' => 'arrow-circle-right',
			'arrow-up' => 'arrow-circle-up',
			'check' => 'check-circle',
			'chevron-left' => 'chevron-left',
			'chevron-right' => 'chevron-right',
			'clock' => 'clock',
			'close' => 'times',
			'close-alt' => 'times-alt',
			'comment' => 'comment-alt',
			'copy' => 'copy',
			'delete' => 'trash-alt',
			'edit' => 'pencil',
			'email' => 'paper-plane',
			'exclamation' => 'exclamation-circle',
			'heart' => 'heart',
			'info' => 'info-circle',
			'link' => 'link',
			'list' => 'list-alt',
			'lock' => 'lock-alt',
			'magic' => 'magic',
			'minus' => 'minus-circle',
			'more' => 'angle-down',
			'move' => 'arrows-alt',
			'question' => 'question-circle',
			'reorder' => 'bars',
			'search' => 'search',
			'settings' => 'cog',
			'share' => 'share-alt',
			'star' => 'star',
			'submit' => 'check',
			'undo' => 'undo',
			'user' => 'user',
			'users' => 'user',
			'warning' => 'exclamation-triangle',
			'write' => 'edit',
		]);
	}

	public function renderIcon($icon, $additional = false)
	{
		if (Str::contains($icon, '.svg')) {
			return $this->renderSvgIcon(locate()->svg($icon), $additional);
		}
		
		if (strrpos($icon, '.')) {
			return $this->renderImageIcon(locate()->image($icon), $additional);
		}

		return $this->renderFontIcon($icon, $additional);
	}

	public function renderImageIcon($icon, $additional = false)
	{
		return app('html')->image($icon, $additional);
	}

	public function renderFontIcon($icon, $additional = false)
	{
		return sprintf($this->iconTemplate, $this->getIcon($icon), $additional);
	}

	public function renderSvgIcon($icon, $additional = false)
	{
		return svg_icon($icon, $additional)->toHtml();
	}
}
