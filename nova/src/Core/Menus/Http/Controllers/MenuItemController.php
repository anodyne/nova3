<?php namespace Nova\Core\Menus\Http\Controllers;

use Str,
	MenuItem,
	BaseController,
	MenuRepositoryContract,
	PageRepositoryContract,
	MenuItemRepositoryContract,
	EditMenuItemRequest, CreateMenuItemRequest, RemoveMenuItemRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

class MenuItemController extends BaseController {

	protected $repo;
	protected $menuRepo;
	protected $pagesRepo;

	public function __construct(MenuItemRepositoryContract $repo,
			MenuRepositoryContract $menus,
			PageRepositoryContract $pages)
	{
		parent::__construct();

		$this->structureView = 'admin';
		$this->templateView = 'admin';

		$this->repo = $repo;
		$this->menuRepo = $menus;
		$this->pagesRepo = $pages;

		$this->middleware('auth');
	}

	public function index($menuId)
	{
		$item = $this->data->item = new MenuItem;

		$this->authorize('manage', $item, "You do not have permission to manage menu items.");

		$this->view = 'admin/menus/menu-items';
		$this->jsView = 'admin/menus/menu-items-js';
		$this->styleView = 'admin/menus/menu-items-style';

		// Grab the menu we want the items for
		$menu = $this->data->menu = $this->menuRepo->find($menuId);

		// Grab the top level menu items
		$this->data->mainMenuItems = $this->repo->getMainMenuItems($menu);
		
		// Now grab any menu items underneath the top level
		$subMenuItems = $this->repo->getSubMenuItems($menu);
		$this->data->subMenuItems = $this->repo->splitSubMenuItemsIntoArray($subMenuItems);
	}

	public function create($menuId)
	{
		$this->authorize('create', new MenuItem, "You do not have permission to create menu items.");

		$this->view = 'admin/menus/menu-item-create';
		$this->jsView = 'admin/menus/menu-item-create-js';

		$this->data->menuId = $menuId;

		$this->data->pages = $this->pagesRepo->listAllBy('verb', 'get', 'name', 'id');

		$this->data->menus = $this->menuRepo->listAll('name', 'id');

		$this->data->linkTypes = [
			''			=> "Please choose a menu item type",
			'page'		=> "A page in Nova",
			'internal'	=> "A full link to a page in Nova",
			'external'	=> "Another page not in Nova",
			'route'		=> "A named route in Nova",
		];
	}

	public function store(CreateMenuItemRequest $request)
	{
		$this->authorize('create', new MenuItem, "You do not have permission to create menu items.");

		$item = $this->repo->create($request->all());

		flash()->success("Menu Item Created!", "Add your new menu item to any of your menus now.");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function edit($itemId)
	{
		$item = $this->data->item = $this->repo->find($itemId);

		$this->authorize('edit', $item, "You do not have permission to edit menu items.");

		$this->view = 'admin/menus/menu-item-edit';
		$this->jsView = 'admin/menus/menu-item-edit-js';

		$this->data->menuId = $item->menu_id;

		$this->data->pages = $this->pagesRepo->listAllBy('verb', 'get', 'name', 'id');

		$this->data->menus = $this->menuRepo->listAll('name', 'id');

		$this->data->linkTypes = [
			''			=> "Please choose a menu item type",
			'page'		=> "A page in Nova",
			'internal'	=> "A full link to a page in Nova",
			'external'	=> "Another page not in Nova",
			'route'		=> "A named route in Nova",
		];
	}

	public function update(EditMenuItemRequest $request, $itemId)
	{
		$this->authorize('edit', new MenuItem, "You do not have permission to edit menu items.");

		$item = $this->repo->update($itemId, $request->all());

		flash()->success("Menu Item Updated!");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function remove($itemId)
	{
		$this->isAjax = true;

		$item = $this->repo->find($itemId);

		if (policy($item)->remove($this->user))
		{
			$body = ($item)
				? view(locate('page', 'admin/menus/menu-item-remove'), compact('item'))
				: alert('danger', "Menu item not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove menu items.");
		}

		return partial('modal-content', [
			'header' => "Remove Menu Item",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveMenuItemRequest $request, $itemId)
	{
		$this->authorize('remove', new MenuItem, "You do not have permission to remove menu items.");

		$item = $this->repo->delete($itemId);

		flash()->success("Menu Item Removed!");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function storeDivider(Request $request)
	{
		$this->isAjax = true;

		if ($this->user->cannot('menu.create'))
		{
			return json_encode(['code' => 0, 'message' => "You do not have permission to create menu items."]);
		}

		$divider = $this->repo->createDivider(['menu_id' => $request->get('menu')]);

		return json_encode(['code' => 1]);
	}

	public function reorder(Request $request)
	{
		$this->isAjax = true;

		if ($this->user->can('menu.edit'))
		{
			$menu = $this->menuRepo->find($request->get('menu'));

			$this->repo->reorder($menu, $request->get('positions'));
		}
	}

}
