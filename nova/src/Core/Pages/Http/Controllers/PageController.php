<?php namespace Nova\Core\Pages\Http\Controllers;

use Flash,
	Input,
	BaseController,
	PageRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;

class PageController extends BaseController {

	protected $repo;

	public function __construct(Application $app, PageRepositoryInterface $repo)
	{
		parent::__construct($app);

		$this->repo = $repo;
	}

	public function index()
	{
		$this->view = 'admin/pages/index';

		$this->data->pages = $this->repo->all();
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

}
