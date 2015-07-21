<?php namespace Nova\Core\Menus\Data\Repositories;

use Menu,
	MenuItem as Model,
	MenuItemRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class MenuItemRepository extends BaseRepository implements MenuItemRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($id)
	{
		// Get the menu item we're deleting
		$item = $this->find($id);

		if ($item)
		{
			// Delete the menu item
			$item->delete();

			return $item;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['menu']);
	}

	public function getMainMenuItems($menu)
	{
		return $this->model->where('menu_id', '=', $menu)
			->where('parent_id', '=', 0)
			->orderBy('order', 'asc')
			->get();
	}

	public function getSubMenuItems($menu)
	{
		return $this->model->where('menu_id', '=', $menu)
			->where('parent_id', '!=', 0)
			->orderBy('order', 'asc')
			->get();
	}

	public function getSubMenuItemsAsArray($menu)
	{
		$items = $this->getSubMenuItems($menu);

		$list = [];

		if ($items)
		{
			foreach ($items as $item)
			{
				$list[$item->parent_id][] = $item;
			}
		}

		return $list;
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
					$itemCollection = $items->filter(function($i) use ($itemId)
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

	public function update($id, array $data)
	{
		// Get the menu item
		$item = $this->find($id);

		if ($item)
		{
			$updatedItem = $item->fill($data);

			$updatedItem->save();

			return $updatedItem;
		}

		return false;
	}

}
