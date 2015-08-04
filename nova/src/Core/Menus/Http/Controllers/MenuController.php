<?php namespace Nova\Core\Menus\Http\Controllers;

use Str,
	Input,
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
		if ( ! $this->user->can(['menu.create', 'menu.edit', 'menu.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage menus.");
		}

		$this->view = 'admin/menus/menus';
		$this->jsView = 'admin/menus/menus-js';

		$this->data->menus = $this->repo->all();
	}

	public function create()
	{
		if ( ! $this->user->can('menu.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create menus.");
		}

		$this->view = 'admin/menus/menu-create';
		$this->jsView = 'admin/menus/menu-create-js';
	}

	public function store(CreateMenuRequest $request)
	{
		if ( ! $this->user->can('menu.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create menus.");
		}

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
		if ( ! $this->user->can('menu.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit menus.");
		}

		$this->view = 'admin/menus/menu-edit';
		$this->jsView = 'admin/menus/menu-edit-js';

		$this->data->menu = $this->repo->find($menuId);
	}

	public function update(EditMenuRequest $request, $menuId)
	{
		if ( ! $this->user->can('menu.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit menus.");
		}

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

		// Grab the menu we're removing
		$menu = $this->repo->find($menuId);

		// Grab all the menus
		$menus = $this->repo->listAllFiltered('name', 'id', $menu->id);

		// Build the body based on whether we found the menu or not
		$body = ($menu)
			? view(locate('page', 'admin/menus/menu-remove'), compact('menu', 'menus'))
			: alert('danger', "Menu not found.");

		return partial('modal-content', [
			'header' => "Remove Menu",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveMenuRequest $request, $menuId)
	{
		if ( ! $this->user->can('menu.remove'))
		{
			return $this->errorUnauthorized("You do not have permission to remove menus.");
		}

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

		$count = $this->repo->countBy('key', Input::get('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function generateMenuKey()
	{
		$this->isAjax = true;

		return Str::slug(Input::get('name'));
	}

	public function pages($menuKey)
	{
		if ( ! $this->user->can(['page.edit', 'menu.edit']))
		{
			return $this->errorUnauthorized("You do not have permission to manage pages for menus.");
		}

		$this->view = 'menu-pages';
		$this->jsView = 'menu-pages-js';

		// Get the menu
		$this->data->menu = $menu = $this->repo->getByKey($menuKey);

		// Get the pages for the menu
		$this->data->pages = $this->repo->getPages($menu);

		// All the menus for the dropdown
		$this->data->menus[] = "No Menu";
		$this->data->menus += $this->repo->listAllFiltered('name', 'id', $menu->id);
	}

	public function updatePages(Request $request, $menuKey)
	{
		if ( ! $this->user->can(['page.edit', 'menu.edit']))
		{
			return $this->errorUnauthorized("You do not have permission to manage pages for menus.");
		}
		
		// Update the pages
		$this->repo->updatePages($request->get('pages'), $request->get('new_menu'));

		// Set the flash message
		flash()->success(Str::plural('Page', count($request->get('pages')))." Updated!");

		return redirect()->route('admin.menus.pages', [$menuKey]);
	}

}
