<?php namespace Nova\Core\Pages\Http\Controllers;

use BaseController,
	PageContentRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;

class PageController extends BaseController {

	protected $repo;

	public function __construct(Application $app, PageContentRepositoryInterface $repo)
	{
		parent::__construct($app);

		$this->repo = $repo;
	}

}
