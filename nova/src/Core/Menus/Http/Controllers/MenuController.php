<?php namespace Nova\Core\Menus\Http\Controllers;

use Str,
	Menu,
	BaseController,
	MenuRepositoryInterface,
	PageRepositoryInterface,
	MenuItemRepositoryInterface,
	EditMenuRequest, CreateMenuRequest, RemoveMenuRequest;
use Nova\Core\Menus\Events;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

class MenuController extends BaseController {

	protected $repo;
	protected $itemRepo;

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
		$this->data->menu = $menu = new Menu;

		$this->authorize('manage', $menu, "You do not have permission to manage menus.");

		$this->view = 'admin/menus/menus';
		$this->jsView = 'admin/menus/menus-js';

		$this->data->menus = $this->repo->all();
	}

	public function create()
	{
		$this->authorize('create', new Menu, "You do not have permission to create menus.");

		$this->view = 'admin/menus/menu-create';
		$this->jsView = 'admin/menus/menu-create-js';
	}

	public function store(CreateMenuRequest $request)
	{
		$this->authorize('create', new Menu, "You do not have permission to create menus.");

		// Create the menu
		$menu = $this->repo->create($request->all());

		// Fire the event
		event(new Events\MenuWasCreated($menu));

		// Set the flash message
		flash()->success("Menu Created!");

		return redirect()->route('admin.menus');
	}

	public function edit($menuId)
	{
		$this->data->menu = $menu = $this->repo->find($menuId);

		$this->authorize('edit', $menu, "You do not have permission to edit menus.");

		$this->view = 'admin/menus/menu-edit';
		$this->jsView = 'admin/menus/menu-edit-js';
	}

	public function update(EditMenuRequest $request, $menuId)
	{
		$this->authorize('edit', new Menu, "You do not have permission to edit menus.");

		// Update the menu
		$menu = $this->repo->update($menuId, $request->all());

		// Fire the event
		event(new Events\MenuWasUpdated($menu));

		// Set the flash message
		flash()->success("Menu Updated!");

		return redirect()->route('admin.menus');
	}

	public function remove($menuId)
	{
		$this->isAjax = true;

		if ($this->user->can('page.remove'))
		{
			// Grab the menu we're removing
			$menu = $this->repo->find($menuId);

			// Grab all the menus
			$menus = $this->repo->listAllFiltered('name', 'id', $menu->id);

			// Build the body based on whether we found the menu or not
			$body = ($menu)
				? view(locate('page', 'admin/menus/menu-remove'), compact('menu', 'menus'))
				: alert('danger', "Menu not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove menus.");
		}

		return partial('modal-content', [
			'header' => "Remove Menu",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveMenuRequest $request, $menuId)
	{
		$this->authorize('remove', new Menu, "You do not have permission to remove menus.");

		// Delete the menu
		$menu = $this->repo->delete($menuId, $request->get('new_menu'));

		// Fire the event
		event(new Events\MenuWasDeleted($menu->key, $menu->name));

		// Set the flash message
		flash()->success("Menu Removed!");

		return redirect()->route('admin.menus');
	}

	public function checkMenuKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function generateMenuKey()
	{
		$this->isAjax = true;

		return Str::slug(request('name'));
	}

	public function pages($menuKey)
	{
		// Get the menu
		$this->data->menu = $menu = $this->repo->getByKey($menuKey);

		$this->authorize('manageMenuPages', $menu, "You do not have permission to manage pages for menus.");

		$this->view = 'menu-pages';
		$this->jsView = 'menu-pages-js';

		// Get the pages for the menu
		$this->data->pages = $this->repo->getPages($menu);

		// All the menus for the dropdown
		$this->data->menus[] = "No Menu";
		$this->data->menus += $this->repo->listAllFiltered('name', 'id', $menu->id);
	}

	public function updatePages(Request $request, $menuKey)
	{
		$this->authorize('manageMenuPages', new Menu, "You do not have permission to manage pages for menus.");

		// Update the pages
		$this->repo->updatePages($request->get('pages'), $request->get('new_menu'));

		// Set the flash message
		flash()->success(Str::plural('Page', count($request->get('pages')))." Updated!");

		return redirect()->route('admin.menus.pages', [$menuKey]);
	}

}
