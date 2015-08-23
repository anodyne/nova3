<?php namespace Nova\Core\Access\Http\Api;

use PermissionRepositoryInterface;
use League\Fractal\Manager;
use Nova\Core\Access\Data\Transformers\PermissionTransformer;
use Nova\Foundation\Http\Controllers\ApiController;

class PermissionController extends ApiController {

	protected $repo;

	public function __construct(Manager $fractal, PermissionRepositoryInterface $repo)
	{
		parent::__construct($fractal);

		$this->repo = $repo;
	}

	public function index()
	{
		return $this->respondWithCollection($this->repo->all(), new PermissionTransformer);
	}

	public function show($permissionId)
	{
		$permission = $this->repo->getById($permissionId);

		if ( ! $permission)
		{
			return $this->errorNotFound('Permission not found');
		}

		return $this->respondWithItem($permission, new PermissionTransformer);
	}

}
