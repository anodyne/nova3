<?php namespace Nova\Core\Access\Http\Controllers;

use Input,
	BaseController,
	RoleRepositoryInterface,
	PermissionRepositoryInterface,
	EditPermissionRequest, CreatePermissionRequest, RemovePermissionRequest;
use Nova\Core\Access\Events;
use Illuminate\Contracts\Foundation\Application;

class PermissionController extends BaseController {

	protected $repo;
	protected $roleRepo;

	public function __construct(Application $app, PermissionRepositoryInterface $repo,
			RoleRepositoryInterface $roles)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->roleRepo = $roles;

		$this->middleware('auth');
	}

	public function index()
	{
		if ( ! $this->user->can(['access.create', 'access.edit', 'access.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage access roles.");
		}

		$this->view = 'admin/access/role-permissions';
		$this->jsView = 'admin/access/role-permissions-js';
	}

	public function create()
	{
		if ($this->user->can('access.create'))
		{
			$this->view = 'admin/pages/page-create';
			$this->jsView = 'admin/pages/page-create-js';

			$this->data->httpVerbs = [
				'GET' => 'GET',
				'POST' => 'POST',
				'PUT' => 'PUT',
				'DELETE' => 'DELETE',
			];

			$this->data->menus[0] = "No menu";
			$this->data->menus += $this->menuRepo->listAll('name', 'id');
		}

		return $this->errorUnauthorized("You do not have permission to create pages.");
	}

	public function store(CreatePageRequest $request)
	{
		if ($this->user->can('access.create'))
		{
			// Create the page
			$page = $this->repo->create($request->all());

			// Fire the event
			event(new Events\PageWasCreated($page));

			// Set the flash message
			flash()->success("Page has been created. Don't forget to update your menu(s) with your new page!");

			return redirect()->route('admin.pages');
		}

		return $this->errorUnauthorized("You do not have permission to create pages.");
	}

	public function edit($pageId)
	{
		if ($this->user->can('access.edit'))
		{
			$this->view = 'admin/pages/page-edit';
			$this->jsView = 'admin/pages/page-edit-js';

			$this->data->page = $this->repo->find($pageId);
			
			$this->data->httpVerbs = [
				'GET' => 'GET',
				'POST' => 'POST',
				'PUT' => 'PUT',
				'DELETE' => 'DELETE',
			];

			$this->data->menus[0] = "No menu";
			$this->data->menus += $this->menuRepo->listAll('name', 'id');
		}

		return $this->errorUnauthorized("You do not have permission to edit pages.");
	}

	public function update(EditPageRequest $request, $pageId)
	{
		if ($this->user->can('access.edit'))
		{
			// Update the page
			$page = $this->repo->update($pageId, $request->all());

			// Fire the event
			event(new Events\PageWasUpdated($page));

			// Set the flash message
			flash()->success("Page has been updated.");

			return redirect()->route('admin.pages');
		}

		return $this->errorUnauthorized("You do not have permission to edit pages.");
	}

	public function remove($pageId)
	{
		$this->isAjax = true;

		if ($this->user->can('access.remove'))
		{
			// Grab the page we're removing
			$page = $this->repo->find($pageId);

			// Build the body based on whether we found the page or not
			$body = ($page)
				? view(locate('page', 'admin/pages/page-remove'), compact('page'))
				: alert('danger', "Page not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove pages.");
		}

		return partial('modal-content', [
			'header' => "Remove Page",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemovePageRequest $request, $pageId)
	{
		if ($this->user->can('access.remove'))
		{
			// Delete the page
			$page = $this->repo->delete($pageId);

			// Fire the event
			event(new Events\PageWasDeleted($page->name, $page->key, $page->uri));

			// Set the flash message
			flash()->success("Page has been removed.");

			return redirect()->route('admin.pages');
		}

		return $this->errorUnauthorized("You do not have permission to remove pages.");
	}

}
