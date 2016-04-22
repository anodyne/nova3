<?php namespace Nova\Api\V1\Controllers;

use PageRepositoryContract;
use Nova\Api\V1\Transformers\PageTransformer;

class PageApiController extends ApiBaseController {

	protected $repo;

	public function __construct(PageRepositoryContract $repo)
	{
		$this->repo = $repo;
	}

	public function index()
	{
		return $this->response->collection($this->repo->all(), new PageTransformer);
	}

	public function show($pageId)
	{
		$page = $this->repo->getById($pageId);

		if ( ! $page)
		{
			return $this->response->errorNotFound('Page not found');
		}

		return $this->response->item($page, new PageTransformer);
	}

}
