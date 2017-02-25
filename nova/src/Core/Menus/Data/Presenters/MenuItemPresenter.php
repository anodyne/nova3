<?php namespace Nova\Core\Menus\Data\Presenters;

use BasePresenter;

class MenuItemPresenter extends BasePresenter {

	public function anchorTag(array $attributes = [])
	{
		$link = $this->entity->link;
		$title = $this->entity->title;

		switch ($this->entity->type) {
			case 'external':
				$attributes = array_merge(['target' => '_blank'], $attributes);

				return link_to($link, $title, $attributes);
			break;

			case 'internal':
				return link_to($link, $title, $attributes);
			break;

			case 'page':
				$page = app('nova.pages')->where('id', $this->entity->page_id)->first();
				//$page = $this->entity->page;

				$title = (empty($title)) ? $page->name : $title;

				return link_to_route($page->key, $title, [], $attributes);
			break;

			case 'route':
				return link_to_route($link, $title, [], $attributes);
			break;
		}
	}

	public function title($withIcon = true)
	{
		$outputArr = [];

		if ($withIcon and ! empty($this->entity->icon)) {
			$outputArr[] = $this->icon();
		}

		if ($this->entity->type == 'page' and empty($this->entity->title)) {
			$outputArr[] = app('nova.pages')->where('id', $this->entity->page_id)->first()
				->present()->name;
			//$outputArr[] = $this->entity->page->present()->name;
		} else {
			$outputArr[] = $this->entity->title;
		}

		return implode(' ', $outputArr);
	}

	public function icon()
	{
		$icon = ($this->entity->icon === null) ? '' : $this->entity->icon;

		return theme()->renderIcon(theme()->getIcon($icon));
	}
}
