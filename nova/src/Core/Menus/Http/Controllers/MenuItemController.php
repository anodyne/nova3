<?php namespace Nova\Core\Menus\Http\Controllers;

use Str,
	Input,
	BaseController,
	MenuRepositoryInterface,
	PageRepositoryInterface,
	MenuItemRepositoryInterface,
	EditMenuItemRequest, CreateMenuItemRequest, RemoveMenuItemRequest;
use Nova\Core\Menus\Events;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

class MenuItemController extends BaseController {

	protected $repo;
	protected $menuRepo;
	protected $pagesRepo;

	public function __construct(Application $app, MenuItemRepositoryInterface $repo,
			MenuRepositoryInterface $menus, PageRepositoryInterface $pages)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->menuRepo = $menus;
		$this->pagesRepo = $pages;

		$this->middleware('auth');
	}

	public function index($menuId)
	{
		if ( ! $this->user->can(['menu.create', 'menu.edit', 'menu.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage menu items.");
		}

		$this->view = 'admin/menus/menu-items';
		$this->jsView = 'admin/menus/menu-items-js';
		$this->styleView = 'admin/menus/menu-items-style';

		// Get the menu
		$this->data->menu = $menu = $this->menuRepo->find($menuId);

		// Get the parent level menu items
		$this->data->mainMenuItems = $this->repo->getMainMenuItems($menu);
		
		// Grab the sub menu items
		$subMenuItems = $this->repo->getSubMenuItems($menu);
		$this->data->subMenuItems = $this->repo->splitSubMenuItemsIntoArray($subMenuItems);
	}

	public function create($menuId)
	{
		if ( ! $this->user->can('menu.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create menu items.");
		}

		$this->view = 'admin/menus/menu-item-create';
		$this->jsView = 'admin/menus/menu-item-create-js';

		// Pass the menu ID over
		$this->data->menuId = $menuId;

		// Get all the GET pages (links wouldn't be able to POST, PUT, or DELETE)
		$this->data->pages = $this->pagesRepo->listAllBy('verb', 'get', 'name', 'id');

		// Get all the menus
		$this->data->menus = $this->menuRepo->listAll('name', 'id');

		// List the different types of links
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
		if ( ! $this->user->can('menu.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create menu items.");
		}

		// Create the menu item
		$item = $this->repo->create($request->all());

		// Fire the event
		event(new Events\MenuItemWasCreated($item));

		// Set the flash message
		flash()->success("Menu item has been created.");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function edit($itemId)
	{
		if ( ! $this->user->can('menu.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit menu items.");
		}

		$this->view = 'admin/menus/menu-item-edit';
		$this->jsView = 'admin/menus/menu-item-edit-js';

		// Get the menu item we're editing
		$this->data->item = $item = $this->repo->find($itemId);

		// Pass the item's menu ID over
		$this->data->menuId = $item->menu_id;

		// Get all the GET pages (links wouldn't be able to POST, PUT, or DELETE)
		$this->data->pages = $this->pagesRepo->listAllBy('verb', 'get', 'name', 'id');

		// Get all the menus
		$this->data->menus = $this->menuRepo->listAll('name', 'id');

		// List the different types of links
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
		if ( ! $this->user->can('menu.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit menu items.");
		}

		// Update the menu item
		$item = $this->repo->update($itemId, $request->all());

		// Fire the event
		event(new Events\MenuItemWasUpdated($item));

		// Set the flash message
		flash()->success("Menu item has been updated.");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function remove($itemId)
	{
		$this->isAjax = true;

		// Grab the menu item we're removing
		$item = $this->repo->find($itemId);

		// Build the body based on whether we found the menu or not
		$body = ($item)
			? view(locate('page', 'admin/menus/menu-item-remove'), compact('item'))
			: alert('danger', "Menu item not found.");

		return partial('modal-content', [
			'header' => "Remove Menu Item",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveMenuItemRequest $request, $itemId)
	{
		if ( ! $this->user->can('menu.remove'))
		{
			return $this->errorUnauthorized("You do not have permission to remove menu items.");
		}

		// Delete the menu item
		$item = $this->repo->delete($itemId);

		// Fire the event
		event(new Events\MenuItemWasDeleted($item->title, $item->link));

		// Set the flash message
		flash()->success("Menu item has been removed.");

		return redirect()->route('admin.menus.items', [$item->menu->id]);
	}

	public function storeDivider(Request $request)
	{
		$this->isAjax = true;

		if ( ! $this->user->can('menu.create'))
		{
			return json_encode(['code' => 0, 'message' => "You do not have permission to create menu items."]);
		}

		// Create the divider
		$divider = $this->repo->create([
			'type'		=> 'divider',
			'menu_id'	=> $request->get('menu')
		]);

		return json_encode(['code' => 1]);
	}

	public function reorder(Request $request)
	{
		$this->isAjax = true;

		// Get the menu collection
		$menu = $this->menuRepo->find($request->get('menu'));

		// Re-order the menu items
		$this->repo->reorder($menu, $request->get('positions'));
	}

}
