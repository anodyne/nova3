<?php namespace Nova\Core\Pages\Http\Controllers;

use Input,
	BaseController,
	PageRepositoryInterface,
	PageContentRepositoryInterface,
	EditPageContentRequest, CreatePageContentRequest, RemovePageContentRequest;
use Nova\Core\Pages\Events;
use Illuminate\Contracts\Foundation\Application;

class PageContentController extends BaseController {

	protected $repo;
	protected $pagesRepo;

	public function __construct(Application $app, PageContentRepositoryInterface $repo,
			PageRepositoryInterface $pages)
	{
		parent::__construct($app);

		$this->repo = $repo;
		$this->pagesRepo = $pages;

		$this->middleware('auth');
	}

	public function index()
	{
		if ( ! $this->user->can(['page.create', 'page.edit', 'page.remove']))
		{
			return $this->errorUnauthorized("You do not have permission to manage page content.");
		}

		$this->view = 'admin/pages/content';
		$this->jsView = 'admin/pages/content-js';
	}

	public function create()
	{
		if ( ! $this->user->can('page.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create page content.");
		}

		$this->view = 'admin/pages/content-create';
		$this->jsView = 'admin/pages/content-create-js';
		
		$this->data->pages[""] = "No page";
		$this->data->pages += $this->pagesRepo->listAllBy('verb', 'GET', 'name', 'id');
	}

	public function store(CreatePageContentRequest $request)
	{
		if ( ! $this->user->can('page.create'))
		{
			return $this->errorUnauthorized("You do not have permission to create page content.");
		}

		// Create the content
		$content = $this->repo->create($request->all());

		// Fire the event
		event(new Events\PageContentWasCreated($content));

		// Set the flash message
		flash()->success("Page Content Created!");

		return redirect()->route('admin.content');
	}

	public function edit($contentId)
	{
		if ( ! $this->user->can('page.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit page content.");
		}

		$this->view = 'admin/pages/content-edit';
		$this->jsView = 'admin/pages/content-edit-js';

		$this->data->content = $this->repo->find($contentId);

		$this->data->pages[""] = "No page";
		$this->data->pages += $this->pagesRepo->listAllBy('verb', 'GET', 'name', 'id');
	}

	public function update(EditPageContentRequest $request, $contentId)
	{
		if ( ! $this->user->can('page.edit'))
		{
			return $this->errorUnauthorized("You do not have permission to edit page content.");
		}

		// Update the content
		$content = $this->repo->update($contentId, $request->all());

		// Fire the event
		event(new Events\PageContentWasUpdated($content));

		// Set the flash message
		flash()->success("Page Content Updated!");

		return redirect()->route('admin.content');
	}

	public function remove($contentId)
	{
		$this->isAjax = true;

		if ($this->user->can('page.remove'))
		{
			// Grab the content we're removing
			$content = $this->repo->find($contentId);

			// Build the body based on whether we found the content or not
			$body = ($content)
				? view(locate('page', 'admin/pages/content-remove'), compact('content'))
				: alert('danger', "Page content not found.");
		}
		else
		{
			$body = alert('danger', "You do not have permission to remove page content.");
		}

		return partial('modal-content', [
			'header' => "Remove Page Content",
			'body' => $body,
			'footer' => false,
		]);
	}

	public function destroy(RemovePageContentRequest $request, $contentId)
	{
		if ( ! $this->user->can('page.remove'))
		{
			return $this->errorUnauthorized("You do not have permission to remove page content.");
		}

		// Delete the content
		$content = $this->repo->delete($contentId);

		// Fire the event
		event(new Events\PageContentWasDeleted($content->key, $content->type));

		// Set the flash message
		flash()->success("Page Content Removed!");

		return redirect()->route('admin.content');
	}

	public function checkContentKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', Input::get('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
