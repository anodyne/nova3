<?php namespace Nova\Core\Menus\Http\Controllers;

use Flash,
	Input,
	BaseController,
	EditMenuRequest,
	CreateMenuRequest,
	RemoveMenuRequest,
	MenuRepositoryInterface,
	MenuItemRepositoryInterface;
use Nova\Core\Menus\Events\MenuWasCreated,
	Nova\Core\Menus\Events\MenuWasDeleted,
	Nova\Core\Menus\Events\MenuWasUpdated;
use Illuminate\Contracts\Foundation\Application;

class MenuController extends BaseController {

	protected $repo;

	public function __construct(Application $app, MenuRepositoryInterface $repo,
			MenuItemRepositoryInterface $items)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->itemRepo = $items;

		$this->middleware('auth');
	}

	public function index()
	{
		$this->view = 'admin/menus/menus';
		$this->jsView = 'admin/menus/menus-js';

		$this->data->menus = $this->repo->all();
	}

	public function items($menuId)
	{
		$this->view = 'admin/menus/menu-items';
		$this->jsView = 'admin/menus/menu-items-js';
		$this->styleView = 'admin/menus/menu-items-style';

		$this->data->menu = $this->repo->find($menuId);
		$this->data->mainMenuItems = $this->itemRepo->getMainMenuItems($menuId);
		$this->data->subMenuItems = $this->itemRepo->getSubMenuItemsAsArray($menuId);
	}

	public function reorder()
	{
		$this->isAjax = true;

		// Get the menu collection
		$menu = $this->repo->find(Input::get('menu'));

		// Re-order the menu items
		$this->itemRepo->reorder($menu, Input::get('positions'));
	}

}
