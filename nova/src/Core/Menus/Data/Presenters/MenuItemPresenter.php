<?php namespace Nova\Core\Menus\Data\Presenters;

use Laracasts\Presenter\Presenter;

class MenuItemPresenter extends Presenter {

	public function anchorTag(array $attributes = [])
	{
		$link = $this->entity->link;
		$title = $this->entity->title;

		switch ($this->entity->type)
		{
			case 'external':
				$attributes = array_merge(['target' => '_blank'], $attributes);

				return link_to($link, $title, $attributes);
			break;

			case 'internal':
				return link_to($link, $title, $attributes);
			break;

			case 'page':
				$page = $this->entity->page;

				return link_to_route($page->key, $page->name, [], $attributes);
			break;
		}
	}

}
