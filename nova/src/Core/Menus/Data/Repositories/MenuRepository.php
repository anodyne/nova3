<?php namespace Nova\Core\Menus\Data\Repositories;

use Menu as Model,
	MenuRepositoryContract,
	PageRepositoryContract,
	MenuItemRepositoryContract;
use Nova\Core\Menus\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class MenuRepository extends BaseRepository implements MenuRepositoryContract {

	protected $model;
	protected $pageRepo;
	protected $menuItemRepo;

	public function __construct(Model $model,
			PageRepositoryContract $pages,
			MenuItemRepositoryContract $menuItems)
	{
		$this->model = $model;
		$this->pageRepo = $pages;
		$this->menuItemRepo = $menuItems;
	}

	public function create(array $data)
	{
		$menu = parent::create($data);

		event(new Events\MenuCreated($menu));

		return $menu;
	}

	public function deleteAndUpdate($resource, $newId)
	{
		// Get the menu we're deleting
		$menu = $this->getResource($resource);

		if ($menu)
		{
			// Grab the repositories we need
			$pageRepo = $this->pageRepo;
			$menuItemRepo = $this->menuItemRepo;

			// Update any pages
			$menu->pages->each(function ($page) use ($newId, $pageRepo)
			{
				$pageRepo->update($page, ['menu_id' => $newId]);
			});

			// Remove the menu items
			$menu->menuItems->each(function ($item) use ($menuItemRepo)
			{
				$menuItemRepo->delete($item);
			});

			// Delete the menu
			$menu->delete();

			event(new Events\MenuDeleted($menu->key, $menu->name));

			return $menu;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['menuItems', 'menuItems.page', 'pages']);
	}

	public function getByKey($key)
	{
		return $this->getFirstBy('key', $key, ['menuItems', 'menuItems.page', 'pages']);
	}

	public function getPages(Model $menu)
	{
		return $menu->pages;
	}

	public function update($resource, array $data)
	{
		$menu = parent::update($resource, $data);

		event(new Events\MenuUpdated($menu));

		return $menu;
	}

	public function updatePages(array $pages, $newMenuId)
	{
		if (count($pages) > 0)
		{
			foreach ($pages as $pageId)
			{
				$this->pageRepo->update($pageId, ['menu_id' => $newMenuId]);
			}

			return true;
		}

		return false;
	}

}
