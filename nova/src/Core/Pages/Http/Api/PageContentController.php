<?php namespace Nova\Core\Pages\Http\Api;

use PageContentRepositoryInterface;
use League\Fractal\Manager;
use Nova\Core\Pages\Api\V1\Transformers\PageContentTransformer;
use Nova\Foundation\Http\Controllers\ApiController;

class PageContentController extends ApiController {

	protected $repo;

	public function __construct(Manager $fractal,
			PageContentRepositoryInterface $repo)
	{
		parent::__construct($fractal);

		$this->repo = $repo;
	}

	public function index()
	{
		return $this->respondWithCollection(
			$this->repo->allExcept(['title', 'header', 'message']),
			new PageContentTransformer
		);
	}

	public function show($contentId)
	{
		$content = $this->repo->getById($contentId);

		if ( ! $content)
		{
			return $this->errorNotFound('Page content not found');
		}

		return $this->respondWithItem($content, new PageContentTransformer);
	}

}
