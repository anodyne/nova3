<?php namespace Nova\Core\Menus\Http\Controllers;

use Str,
	Menu,
	BaseController,
	MenuRepositoryContract,
	PageRepositoryContract,
	MenuItemRepositoryContract,
	EditMenuRequest, CreateMenuRequest, RemoveMenuRequest;
use Illuminate\Http\Request;
use Illuminate\Contracts\Foundation\Application;

class MenuController extends BaseController {

	protected $repo;
	protected $itemRepo;

	public function __construct(MenuRepositoryContract $repo,
			MenuItemRepositoryContract $items)
	{
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->itemRepo = $items;

		$this->middleware('auth');
	}

	public function all()
	{
		$menu = $this->data->menu = new Menu;

		$this->authorize('manage', $menu, "You do not have permission to manage menus.");

		$this->views->put('page', 'admin/menus/menus');
		$this->views->put('scripts', ['admin/menus/menus']);

		$this->data->menus = $this->repo->all();
	}

	public function create()
	{
		$this->authorize('create', new Menu, "You do not have permission to create menus.");

		$this->views->put('page', 'admin/menus/menu-create');
		$this->views->put('scripts', ['admin/menus/menu-create']);

		$this->data->keyCheckUrl = route('admin.menus.checkKey');
	}

	public function store(CreateMenuRequest $request)
	{
		$this->authorize('create', new Menu, "You do not have permission to create menus.");

		$menu = $this->repo->create($request->all());

		flash()->success("Menu Created!");

		return redirect()->route('admin.menus');
	}

	public function edit($menuId)
	{
		$menu = $this->data->menu = $this->repo->find($menuId);

		$this->authorize('edit', $menu, "You do not have permission to edit menus.");

		$this->views->put('page', 'admin/menus/menu-edit');
		$this->views->put('scripts', ['admin/menus/menu-edit']);

		$this->data->keyCheckUrl = route('admin.menus.checkKey');
	}

	public function update(EditMenuRequest $request, $menuId)
	{
		$this->authorize('edit', new Menu, "You do not have permission to edit menus.");

		$menu = $this->repo->update($menuId, $request->all());

		flash()->success("Menu Updated!");

		return redirect()->route('admin.menus');
	}

	public function remove($menuId)
	{
		$this->isAjax = true;

		$menu = $this->repo->find($menuId);

		if (policy($menu)->remove(user()))
		{
			$menus = $this->repo->listAllFiltered('name', 'id', $menu->id);

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

		$menu = $this->repo->deleteAndUpdate($menuId, $request->get('new_menu'));

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
		$menu = $this->data->menu = $this->repo->getByKey($menuKey);

		$this->authorize('manageMenuPages', $menu, "You do not have permission to manage pages for menus.");

		$this->views->put('page', 'admin/menus/menu-pages');
		$this->views->put('scripts', ['admin/menus/menu-pages']);

		$this->data->menus[] = "No Menu";
		$this->data->menus += $this->repo->listAllFiltered('name', 'id', $menu->id);

		$this->data->pages = $this->repo->getPages($menu)->toArray();
	}

	public function updatePages(Request $request, $menuKey)
	{
		$this->authorize('manageMenuPages', new Menu, "You do not have permission to manage pages for menus.");

		$this->repo->updatePages($request->get('pages'), $request->get('new_menu'));

		flash()->success(Str::plural('Page', count($request->get('pages')))." Updated!");

		return redirect()->route('admin.menus.pages', [$menuKey]);
	}

}
