<?php namespace Nova\Core\Pages\Api\V1\Controllers;

use PageContentRepositoryInterface;
use Nova\Foundation\Api\V1\Controllers\ApiBaseController;
use Nova\Core\Pages\Api\V1\Transformers\PageContentTransformer;

class PageContentController extends ApiBaseController {

	protected $repo;

	public function __construct(PageContentRepositoryInterface $repo)
	{
		$this->repo = $repo;
	}

	public function index()
	{
		return $this->response->collection(
			$this->repo->allExcept(['title', 'header', 'message']),
			new PageContentTransformer
		);
	}

	public function show($contentId)
	{
		$content = $this->repo->getById($contentId);

		if ( ! $content)
		{
			return $this->response->errorNotFound('Page content not found');
		}

		return $this->response->item($content, new PageContentTransformer);
	}

}
