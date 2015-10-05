<?php namespace Nova\Core\Pages\Http\Controllers;

use Page,
	BaseController,
	MenuRepositoryInterface,
	PageRepositoryInterface,
	EditPageRequest, CreatePageRequest, RemovePageRequest;
use Nova\Core\Pages\Events;

class PageController extends BaseController {

	protected $repo;
	protected $menuRepo;

	public function __construct(PageRepositoryInterface $repo,
			MenuRepositoryInterface $menus)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->menuRepo = $menus;

		$this->middleware('auth');
	}

	public function index()
	{
		$page = $this->data->page = new Page;

		$this->authorize('manage', $page, "You do not have permission to manage pages.");

		$this->view = 'admin/pages/pages';
		$this->jsView = 'admin/pages/pages-js';
	}

	public function create()
	{
		$this->authorize('create', new Page, "You do not have permission to create pages.");

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

	public function store(CreatePageRequest $request)
	{
		$this->authorize('create', new Page, "You do not have permission to create pages.");

		$page = $this->repo->create($request->all());

		event(new Events\PageWasCreated($page));

		flash()->success("Page Created!", "Don't forget to update your menus with your new page.");

		return redirect()->route('admin.pages');
	}

	public function edit($pageId)
	{
		$page = $this->data->page = $this->repo->find($pageId);

		$this->authorize('edit', $page, "You do not have permission to edit pages.");

		$this->view = 'admin/pages/page-edit';
		$this->jsView = 'admin/pages/page-edit-js';

		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];

		$this->data->menus[0] = "No menu";
		$this->data->menus += $this->menuRepo->listAll('name', 'id');
	}

	public function update(EditPageRequest $request, $pageId)
	{
		$page = $this->repo->find($pageId);

		$this->authorize('edit', $page, "You do not have permission to edit pages.");

		$page = $this->repo->update($page, $request->all());

		event(new Events\PageWasUpdated($page));

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
		$page = $this->repo->find($pageId);

		$this->authorize('remove', $page, "You do not have permission to remove pages.");

		$page = $this->repo->delete($page);

		event(new Events\PageWasDeleted($page->name, $page->key, $page->uri));

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

}
