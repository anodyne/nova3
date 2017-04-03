<?php namespace Nova\Core\Pages\Http\Controllers;

use Page;
use MenuRepositoryContract;
use PageRepositoryContract;
use EditPageRequest;
use CreatePageRequest;
use RemovePageRequest;
use Symfony\Component\Finder\Finder;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionMethod;
use Nova\Foundation\Http\Controllers\NovaController;

class PageController extends NovaController
{
	protected $repo;
	protected $menuRepo;

	public function __construct(PageRepositoryContract $repo, MenuRepositoryContract $menus)
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
			'vue/access-picker',
			'admin/pages/page-create',
		]);
		$this->views->put('styles', ['typeahead']);
		
		$this->data->httpVerbs = [
			'GET' => _m('pages-verb-get'),
			'POST' => _m('pages-verb-post'),
			'PUT' => _m('pages-verb-put'),
			'DELETE' => _m('pages-verb-delete'),
		];

		$this->data->menus[0] = "No menu";
		$this->data->menus += $this->menuRepo->listAll('name', 'id');

		$this->data->resources = $this->getExtensionResources();

		$this->data->keyCheckUrl = route('admin.pages.checkKey');
		$this->data->uriCheckUrl = route('admin.pages.checkUri');

		$this->data->roles = app('RoleRepository')->all();
		$this->data->permissions = app('PermissionRepository')->all();
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
			'vue/access-picker',
			'admin/pages/page-edit',
		]);
		$this->views->put('styles', ['typeahead']);

		$this->data->httpVerbs = [
			'GET' => _m('pages-verb-get'),
			'POST' => _m('pages-verb-post'),
			'PUT' => _m('pages-verb-put'),
			'DELETE' => _m('pages-verb-delete'),
		];

		$this->data->menus[0] = "No menu";
		$this->data->menus += $this->menuRepo->listAll('name', 'id');

		$this->data->resources = $this->getExtensionResources();

		$this->data->keyCheckUrl = route('admin.pages.checkKey');
		$this->data->uriCheckUrl = route('admin.pages.checkUri');

		$this->data->roles = app('RoleRepository')->all();
		$this->data->permissions = app('PermissionRepository')->all();
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

		if (policy($page)->remove($this->user)) {
			$body = ($page)
				? view(locate('page', 'admin/pages/page-remove'), compact('page'))
				: alert('danger', "Page not found.");
		} else {
			$body = alert('danger', _m('phrase-no-permissions-remove', [_m('pages')]));
		}

		return partial('modal-content', [
			'header' => "Remove Page",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemovePageRequest $request, $pageId)
	{
		$this->authorize('remove', new Page, _m('phrase-no-permissions-remove', [_m('pages')]));

		$page = $this->repo->delete($pageId);

		flash()->success(_m('phrase-removed', [_m('page')]));

		return redirect()->route('admin.pages');
	}

	public function checkPageKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0) {
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function checkPageUri()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('uri', request('uri'));

		if ($count > 0) {
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	protected function getExtensionResources()
	{
		try {
			$finder = new Finder;
			$finder->files()->in('extensions/*/*/Http/Controllers');

			$methodList = ["" => _m('pages-no-resource')];

			foreach ($finder as $file) {
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

				foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
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
		} catch (InvalidArgumentException $e) {
			return _m('pages-no-extension-controllers');
		}
	}
}
