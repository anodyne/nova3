<?php namespace Nova\Core\Pages\Http\Api;

use PageRepositoryInterface;
use League\Fractal\Manager;
use Nova\Core\Pages\Data\Transformers\PageTransformer;
use Nova\Foundation\Http\Controllers\ApiController;

class PageController extends ApiController {

	protected $repo;

	public function __construct(Manager $fractal,
			PageRepositoryInterface $repo)
	{
		parent::__construct($fractal);

		$this->repo = $repo;
	}

	public function index()
	{
		return $this->respondWithCollection($this->repo->all(), new PageTransformer);
	}

	public function show($pageId)
	{
		$page = $this->repo->getById($pageId);

		if ( ! $page)
		{
			return $this->errorNotFound('Page not found');
		}

		return $this->respondWithItem($page, new PageTransformer);
	}

}
