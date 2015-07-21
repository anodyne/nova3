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

class MenuItemController extends BaseController {

	protected $repo;
	protected $menuRepo;

	public function __construct(Application $app, MenuItemRepositoryInterface $repo,
			MenuRepositoryInterface $menus)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->menuRepo = $menus;

		$this->middleware('auth');
	}

	public function index($menuId)
	{
		$this->view = 'admin/menus/items';
		$this->jsView = 'admin/menus/items-js';
		$this->styleView = 'admin/menus/items-style';

		$this->data->menu = $this->menuRepo->find($menuId);
		$this->data->mainMenuItems = $this->repo->getMainMenuItems($menuId);
		$this->data->subMenuItems = $this->repo->getSubMenuItemsAsArray($menuId);
	}

	public function create()
	{
		$this->view = 'admin/menus/item-create';
		$this->jsView = 'admin/menus/item-create-js';
	}

	public function store(CreateMenuItemRequest $request)
	{
		// Create the menu item
		$item = $this->repo->create($request->all());

		// Fire the event
		event(new Events\MenuItemWasCreated($item));

		// Set the flash message
		flash()->success("Menu item has been created.");

		return redirect()->route('admin.menus');
	}

	public function edit($itemId)
	{
		$this->view = 'admin/menus/item-edit';
		$this->jsView = 'admin/menus/item-edit-js';

		$this->data->item = $this->repo->find($itemId);
	}

	public function update(EditMenuItemRequest $request, $itemId)
	{
		// Update the menu item
		$item = $this->repo->update($itemId, $request->all());

		// Fire the event
		event(new Events\MenuItemWasUpdated($item));

		// Set the flash message
		flash()->success("Menu item has been updated.");

		return redirect()->route('admin.menus');
	}

	public function remove($itemId)
	{
		$this->isAjax = true;

		// Grab the menu item we're removing
		$item = $this->repo->find($itemId);

		// Build the body based on whether we found the menu or not
		$body = ($item)
			? view(locate('page', 'admin/menus/item-remove'), compact('item'))
			: alert('danger', "Menu item not found.");

		return partial('modal-content', [
			'header' => "Remove Menu Item",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemoveMenuItemRequest $request, $itemId)
	{
		// Delete the menu item
		$item = $this->repo->delete($itemId);

		// Fire the event
		event(new Events\MenuItemWasDeleted($item->title, $item->link));

		// Set the flash message
		flash()->success("Menu Item has been removed.");

		return redirect()->route('admin.menus');
	}

}
