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

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->menuRepo = $menus;
		$this->pagesRepo = $pages;

		$this->middleware('auth');
	}

	public function all($menuId)
	{
		$item = $this->data->item = new MenuItem;

		$this->authorize('manage', $item, "You do not have permission to manage menu items.");

		$this->views->put('page', 'admin/menus/menu-items');
		$this->views->put('scripts', [
			'uikit/core/core.min',
			'uikit/components/nestable.min',
			'admin/menus/menu-items',
		]);
		$this->views->put('styles', [
			'uikit/components/icon',
			'uikit/components/nestable.min',
		]);

		// Grab the menu we want the items for
		$menu = $this->data->menu = $this->menuRepo->find($menuId);

		// Grab the top level menu items
		$this->data->mainMenuItems = $this->repo->getMainMenuItems($menu);
		
		// Now grab any menu items underneath the top level
		$subMenuItems = $this->repo->getSubMenuItems($menu);
		$this->data->subMenuItems = $this->repo->splitSubMenuItemsIntoArray($subMenuItems);

		$this->data->reorderUrl = route('admin.menu.items.reorder');
		$this->data->storeDividerUrl = route('admin.menus.items.storeDivider');
	}

	public function create($menuId)
	{
		$this->authorize('create', new MenuItem, "You do not have permission to create menu items.");

		$this->views->put('page', 'admin/menus/menu-item-create');
		$this->views->put('scripts', [
			'typeahead.bundle.min',
			'vue/access-picker',
			'vue/icon-picker',
			'admin/menus/menu-item-create'
		]);
		$this->views->put('styles', ['typeahead']);

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

		$this->data->accessTypes = [
			'' => "None",
			'role_all' => "All Selected Access Roles",
			'role_any' => "Any Selected Access Roles",
			//'permission_all' => "All Selected Permissions",
			//'permission_any' => "Any Selected Permissions",
		];

		$this->data->roles = $this->data->accessRoles = app('RoleRepository')->all();
		$this->data->permissions = app('PermissionRepository')->all();

		$this->data->icons = theme()->buildIconList();
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

		$this->views->put('page', 'admin/menus/menu-item-edit');
		$this->views->put('scripts', ['admin/menus/menu-item-edit']);

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
