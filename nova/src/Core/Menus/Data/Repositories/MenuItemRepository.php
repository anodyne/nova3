<?php namespace Nova\Core\Menus\Data\Repositories;

use Menu,
	MenuItem as Model,
	MenuItemRepositoryContract;
use Nova\Core\Menus\Events;
use Illuminate\Support\Collection;
use Nova\Foundation\Data\Repositories\BaseRepository;

class MenuItemRepository extends BaseRepository implements MenuItemRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	/**
	 * We need to override how we create pages to make sure we don't store
	 * a page ID when the type isn't "page"
	 */
	public function create(array $data)
	{
		// Don't store a page ID unless the menu item type is page
		if ($data['type'] != 'page')
		{
			unset($data['page_id']);
		}

		$item = parent::create($data);

		event(new Events\MenuItemCreated($item));

		return $item;
	}

	public function createDivider(array $data)
	{
		return $this->create(array_merge(['type' => 'divider'], $data));
	}

	public function delete($resource)
	{
		$item = parent::delete($resource);

		event(new Events\MenuItemDeleted($item->title, $item->link));

		return $item;
	}

	public function find($id)
	{
		return $this->getById($id, ['menu', 'page']);
	}

	public function getMainMenuItems($menu)
	{
		if ($menu instanceof Menu)
		{
			$items = $menu->menuItems->filter(function ($item)
			{
				return (int) $item->parent_id === 0;
			})->sortBy('order');

			if ( ! user())
			{
				$items = $items->filter(function ($item)
				{
					return (bool) $item->authentication === false;
				});
			}

			return $items;
		}

		$query = $this->model->where('menu_id', '=', $menu)
			->where('parent_id', '=', 0)
			->orderBy('order', 'asc');

		if ( ! user())
		{
			$query = $query->where('authentication', '=', (int) false);
		}

		return $query->get();
	}

	public function getSubMenuItems($menu)
	{
		if ($menu instanceof Menu)
		{
			$items = $menu->menuItems->filter(function ($item)
			{
				return (int) $item->parent_id != 0;
			})->sortBy('order');

			if ( ! user())
			{
				$items = $items->filter(function ($item)
				{
					return (bool) $item->authentication === false;
				});
			}

			return $items;
		}

		$query = $this->model->where('menu_id', '=', $menu)
			->where('parent_id', '!=', 0)
			->orderBy('order', 'asc');

		if ( ! user())
		{
			$query = $query->where('authentication', '=', (int) false);
		}

		return $query->get();
	}

	public function reorder(Menu $menu, array $newPositions)
	{
		// Get all the menu items
		$items = $menu->menuItems;

		foreach ($newPositions as $parentId => $positions)
		{
			if (is_array($positions))
			{
				foreach ($positions as $order => $itemId)
				{
					$itemCollection = $items->filter(function ($i) use ($itemId)
					{
						return $i->id == $itemId;
					});

					foreach ($itemCollection as $item)
					{
						$item->fill([
							'order'		=> $order,
							'parent_id'	=> $parentId,
						])->save();
					}
				}
			}
		}
	}

	public function splitSubMenuItemsIntoArray(Collection $menuItemCollection)
	{
		$list = [];

		foreach ($menuItemCollection as $item)
		{
			$list[$item->parent_id][] = $item;
		}

		return $list;
	}

	public function update($resource, array $data)
	{
		$item = parent::update($resource, $data);

		event(new Events\MenuItemUpdated($item));

		return $item;
	}

}
