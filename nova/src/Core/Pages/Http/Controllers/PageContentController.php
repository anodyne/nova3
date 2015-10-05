<?php namespace Nova\Core\Pages\Http\Controllers;

use PageContent,
	BaseController,
	PageRepositoryInterface,
	PageContentRepositoryInterface,
	EditPageContentRequest, CreatePageContentRequest, RemovePageContentRequest;
use Nova\Core\Pages\Events;

class PageContentController extends BaseController {

	protected $repo;
	protected $pagesRepo;

	public function __construct(PageContentRepositoryInterface $repo,
			PageRepositoryInterface $pages)
	{
		parent::__construct();

		$this->repo = $repo;
		$this->pagesRepo = $pages;

		$this->middleware('auth');
	}

	public function index()
	{
		$content = $this->data->content = new PageContent;

		$this->authorize('manage', $content, "You do not have permission to manage additional content.");

		$this->view = 'admin/pages/content';
		$this->jsView = 'admin/pages/content-js';
	}

	public function create()
	{
		$this->authorize('create', new PageContent, "You do not have permission to create additional content.");

		$this->view = 'admin/pages/content-create';
		$this->jsView = 'admin/pages/content-create-js';
		
		$this->data->pages[""] = "No page";
		$this->data->pages += $this->pagesRepo->listAllBy('verb', 'GET', 'name', 'id');
	}

	public function store(CreatePageContentRequest $request)
	{
		$this->authorize('create', new PageContent, "You do not have permission to create additional content.");

		$content = $this->repo->create($request->all());

		event(new Events\PageContentWasCreated($content));

		flash()->success("Page Content Created!");

		return redirect()->route('admin.content');
	}

	public function edit($contentId)
	{
		$content = $this->data->content = $this->repo->find($contentId);

		$this->authorize('edit', $content, "You do not have permission to edit additional content.");

		$this->view = 'admin/pages/content-edit';
		$this->jsView = 'admin/pages/content-edit-js';

		$this->data->pages[""] = "No page";
		$this->data->pages += $this->pagesRepo->listAllBy('verb', 'GET', 'name', 'id');
	}

	public function update(EditPageContentRequest $request, $contentId)
	{
		$content = $this->repo->find($contentId);

		$this->authorize('edit', $content, "You do not have permission to edit additional content.");

		$content = $this->repo->update($content, $request->all());

		event(new Events\PageContentWasUpdated($content));

		flash()->success("Page Content Updated!");

		return redirect()->route('admin.content');
	}

	public function remove($contentId)
	{
		$this->isAjax = true;

		$content = $this->repo->find($contentId);

		if (policy($content)->remove($this->user))
		{
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
		$content = $this->repo->find($contentId);

		$this->authorize('remove', $content, "You do not have permission to remove additional content.");

		$content = $this->repo->delete($content);

		event(new Events\PageContentWasDeleted($content->key, $content->type));

		flash()->success("Page Content Removed!");

		return redirect()->route('admin.content');
	}

	public function checkContentKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countBy('key', request('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
