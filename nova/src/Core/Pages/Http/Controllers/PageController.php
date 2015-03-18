<?php namespace Nova\Core\Pages\Http\Controllers;

use Flash,
	Input,
	BaseController,
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
		$this->view = 'admin/pages/index';
		$this->jsView = 'admin/pages/index_js';
	}

	public function create()
	{
		$this->view = 'admin/pages/create';
		$this->jsView = 'admin/pages/create_js';

		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];
	}

	public function store()
	{
		// Create the page
		$page = $this->repo->create(Input::all());

		// Fire the event
		event(new PageWasCreated($page));

		// Set the flash message
		Flash::success("Page has been created.");

		return redirect()->route('admin.pages');
	}

	public function edit($pageId)
	{
		$this->view = 'admin/pages/edit';

		$this->data->page = $this->repo->getById($pageId);
		$this->data->httpVerbs = [
			'GET' => 'GET',
			'POST' => 'POST',
			'PUT' => 'PUT',
			'DELETE' => 'DELETE',
		];
	}

	public function update($pageId)
	{
		// Fire the event
		event(new PageWasUpdated($page));
	}

	public function remove()
	{
		# code...
	}

	public function destroy()
	{
		// Fire the event
		event(new PageWasDeleted($page));
	}

	public function checkPageKey()
	{
		$this->isAjax = true;

		$count = $this->repo->countRouteKeys(Input::get('key'));

		if ($count > 0)
		{
			return json_encode(['code' => 0]);
		}

		return json_encode(['code' => 1]);
	}

}
