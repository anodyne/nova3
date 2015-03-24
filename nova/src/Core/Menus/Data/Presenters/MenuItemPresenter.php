<?php namespace Nova\Core\Menus\Data\Presenters;

use HTML;
use Laracasts\Presenter\Presenter;

class MenuItemPresenter extends Presenter {

	public function anchorTag(array $attributes = [])
	{
		$link = $this->entity->link;
		$title = $this->entity->title;

		switch ($this->entity->type)
		{
			case 'route':
				return HTML::linkRoute($link, $title, [], $attributes);
			break;

			case 'offsite':
				$attributes = array_merge(['target' => '_blank'], $attributes);

				return HTML::link($link, $title, $attributes);
			break;

			case 'onsite':
				return HTML::link($link, $title, $attributes);
			break;

			case 'page':
				$page = $this->entity->page;

				return HTML::linkRoute($page->key, $page->name, [], $attributes);
			break;
		}
	}

}
