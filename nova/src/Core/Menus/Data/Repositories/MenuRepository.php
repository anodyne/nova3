<?php namespace Nova\Core\Menus\Data\Repositories;

use Menu as Model,
	MenuRepositoryInterface,
	PageRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class MenuRepository extends BaseRepository implements MenuRepositoryInterface {

	protected $model;
	protected $pageRepo;

	public function __construct(Model $model, PageRepositoryInterface $pages)
	{
		$this->model = $model;
		$this->pageRepo = $pages;
	}

	public function deleteAndUpdate($resource, $newId)
	{
		// Get the menu we're deleting
		$menu = $this->getResource($resource);

		if ($menu)
		{
			// Update any pages
			$menu->pages->each(function ($page) use ($newId)
			{
				$page->fill(['menu_id' => $newId])->save();
			});

			// Remove the menu items
			$menu->menuItems->each(function ($item)
			{
				$item->delete();
			});

			// Delete the menu
			$menu->delete();

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
