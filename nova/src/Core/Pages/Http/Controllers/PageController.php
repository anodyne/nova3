<?php namespace Nova\Core\Pages\Http\Controllers;

use Flash,
	Input,
	BaseController,
	EditPageRequest,
	CreatePageRequest,
	RemovePageRequest,
	PageRepositoryInterface;
use Nova\Core\Pages\Events\PageWasCreated,
	Nova\Core\Pages\Events\PageWasDeleted,
	Nova\Core\Pages\Events\PageWasUpdated;
use Illuminate\Contracts\Foundation\Application;

class PageController extends BaseController {

	protected $repo;

	public function __construct(Application $app, PageRepositoryInterface $repo)
	{
		parent::__construct($app);

		$this->repo = $repo;

		$this->middleware('auth');
	}

	public function index()
	{
		$this->view = 'admin/pages/pages';
		$this->jsView = 'admin/pages/pages-js';
	}

	public function create()
	{
		$this->view = 'admin/pages/page-create';
		$this->jsView = 'admin/pages/page-create-js';

		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];
	}

	public function store(CreatePageRequest $request)
	{
		// Create the page
		$page = $this->repo->create(Input::all());

		// Fire the event
		event(new PageWasCreated($page));

		// Set the flash message
		Flash::success("Page has been created. Don't forget to update your menu(s) with your new page!");

		return redirect()->route('admin.pages');
	}

	public function edit($pageId)
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
	}

	public function update(EditPageRequest $request, $pageId)
	{
		// Update the page
		$page = $this->repo->update($pageId, Input::all());

		// Fire the event
		event(new PageWasUpdated($page));

		// Set the flash message
		Flash::success("Page has been updated.");

		return redirect()->route('admin.pages');
	}

	public function remove($pageId)
	{
		$this->isAjax = true;

		// Grab the page we're removing
		$page = $this->repo->find($pageId);

		// Build the body based on whether we found the page or not
		$body = ($page)
			? view(locate('page', 'admin/pages/page-remove'), compact('page'))
			: alert('danger', "Page not found.");

		return partial('modal-content', [
			'header' => "Remove Page",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemovePageRequest $request, $pageId)
	{
		// Delete the page
		$page = $this->repo->delete($pageId);

		// Fire the event
		event(new PageWasDeleted($page->name, $page->key, $page->uri));

		// Set the flash message
		Flash::success("Page has been removed.");

		return redirect()->route('admin.pages');
	}

	public function checkPageKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', Input::get('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

	public function checkPageUri()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('uri', Input::get('uri'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
