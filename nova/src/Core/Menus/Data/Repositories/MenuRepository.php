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

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($id, $newId)
	{
		// Get the menu we're deleting
		$menu = $this->find($id);

		if ($menu)
		{
			// If we have pages, loop through and update the menu they use
			if ($menu->pages->count() > 0)
			{
				foreach ($menu->pages as $page)
				{
					$page->fill(['menu_id' => $newId])->save();
				}
			}

			// Delete the menu
			$menu->delete();

			return $menu;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['menuItems', 'pages']);
	}

	public function getByKey($key)
	{
		return $this->getFirstBy('key', $key, ['menuItems', 'pages']);
	}

	public function getPages(Model $menu)
	{
		return $menu->pages;
	}

	public function update($id, array $data)
	{
		// Get the menu
		$menu = $this->find($id);

		if ($menu)
		{
			$updatedMenu = $menu->fill($data);

			$updatedMenu->save();

			return $updatedMenu;
		}

		return false;
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
