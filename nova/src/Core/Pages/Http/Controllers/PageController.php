<?php namespace Nova\Core\Pages\Http\Controllers;

use Page,
	BaseController,
	MenuRepositoryContract,
	PageRepositoryContract,
	EditPageRequest, CreatePageRequest, RemovePageRequest;
use Symfony\Component\Finder\Finder;
use InvalidArgumentException;
use ReflectionClass, ReflectionMethod;

class PageController extends BaseController {

	protected $repo;
	protected $menuRepo;

	public function __construct(PageRepositoryContract $repo,
			MenuRepositoryContract $menus)
	{
		parent::__construct();

		$this->isAdmin = true;

		$this->views->put('structure', 'admin');
		$this->views->put('template', 'admin');

		$this->repo = $repo;
		$this->menuRepo = $menus;

		$this->middleware('auth');
	}

	public function all()
	{
		$page = $this->data->page = new Page;

		$this->authorize('manage', $page, "You do not have permission to manage pages.");

		$this->views->put('page', 'admin/pages/pages');
		$this->views->put('scripts', ['admin/pages/pages']);

		$this->data->pages = $this->repo->all()->toArray();
	}

	public function create()
	{
		$this->authorize('create', new Page, "You do not have permission to create pages.");

		$this->views->put('page', 'admin/pages/page-create');
		$this->views->put('scripts', [
			'typeahead.bundle.min',
			'bootstrap-tagsinput.min',
			'admin/pages/page-create',
		]);
		$this->views->put('styles', [
			'bootstrap-tagsinput',
			'bootstrap-tagsinput-typeahead',
		]);
		
		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];

		$this->data->menus[0] = "No menu";
		$this->data->menus += $this->menuRepo->listAll('name', 'id');

		$this->data->resources = $this->getExtensionResources();

		$this->data->accessTypes = [
			'' => "None",
			'role_all' => "All Selected Access Roles",
			'role_any' => "Any Selected Access Roles",
			//'permission_all' => "All Selected Permissions",
			//'permission_any' => "Any Selected Permissions",
		];

		$this->data->accessRoles = app('RoleRepository')->all();

		$this->data->keyCheckUrl = route('admin.pages.checkKey');
		$this->data->uriCheckUrl = route('admin.pages.checkUri');
		$this->data->permissionApiUrl = version('v1')->route('api.access.permissions.all');
	}

	public function store(CreatePageRequest $request)
	{
		$this->authorize('create', new Page, "You do not have permission to create pages.");

		$page = $this->repo->create($request->all());

		flash()->success("Page Created!", "Don't forget to update your menus with your new page.");

		return redirect()->route('admin.pages');
	}

	public function edit($pageId)
	{
		$page = $this->data->page = $this->repo->find($pageId);

		$this->authorize('edit', $page, "You do not have permission to edit pages.");

		$this->views->put('page', 'admin/pages/page-edit');
		$this->views->put('scripts', [
			'typeahead.bundle.min',
			'bootstrap-tagsinput.min',
			'admin/pages/page-edit',
		]);
		$this->views->put('styles', [
			'bootstrap-tagsinput',
			'bootstrap-tagsinput-typeahead',
		]);

		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];

		$this->data->menus[0] = "No menu";
		$this->data->menus += $this->menuRepo->listAll('name', 'id');

		$this->data->resources = $this->getExtensionResources();

		$this->data->accessTypes = [
			'' => "None",
			'role_all' => "All Selected Access Roles",
			'role_any' => "Any Selected Access Roles",
			//'permission_all' => "All Selected Permissions",
			//'permission_any' => "Any Selected Permissions",
		];

		$this->data->accessRoles = app('RoleRepository')->all();

		$this->data->keyCheckUrl = route('admin.pages.checkKey');
		$this->data->uriCheckUrl = route('admin.pages.checkUri');
		$this->data->permissionApiUrl = version('v1')->route('api.access.permissions.index');
	}

	public function update(EditPageRequest $request, $pageId)
	{
		$this->authorize('edit', new Page, "You do not have permission to edit pages.");

		$page = $this->repo->update($pageId, $request->all());

		flash()->success("Page Updated!");

		return redirect()->route('admin.pages');
	}

	public function remove($pageId)
	{
		$this->isAjax = true;

		$page = $this->repo->find($pageId);

		if (policy($page)->remove($this->user))
		{
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
		$this->authorize('remove', new Page, "You do not have permission to remove pages.");

		$page = $this->repo->delete($pageId);

		flash()->success("Page Removed!");

		return redirect()->route('admin.pages');
	}

	public function checkPageKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function checkPageUri()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('uri', request('uri'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	protected function getExtensionResources()
	{
		try
		{
			$finder = new Finder;
			$finder->files()->in('extensions/*/*/Http/Controllers');

			$methodList = ["" => "No resource"];

			foreach ($finder as $file)
			{
				$className = str_replace('.php', '', $file->getPathname());
				$className = str_replace('/', '\\', $className);
				$className = ucfirst($className);

				// Break the full class name up into pieces
				$classPieces = explode("\\", $className);

				// "Extensions" will always be 0, so the vendor is 1 and extension is 2
				$vendorName = $classPieces[1];
				$extensionName = $classPieces[2];

				// This gives us a shorter class name for display purposes only
				$shortResourceClass = substr($className, (strrpos($className, '\\') + 1));

				// Get the information about the class
				$reflection = new ReflectionClass($className);

				foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
				{
					// The full resource is what we need in the database, so that's our value
					$resource = "{$className}@{$method->getName()}";

					// The short resource just gives us a more human readable class/method name
					$shortResource = "{$shortResourceClass}@{$method->getName()}";

					// Build a group name made up of the vendor and extension name
					$groupName = "{$vendorName} - {$extensionName}";

					// Finally, add it to the list
					$methodList[$groupName][$resource] = $shortResource;

					asort($methodList[$groupName]);
				}
			}

			return $methodList;
		}
		catch (InvalidArgumentException $e)
		{
			return "No extension controllers found!";
		}
	}

}
