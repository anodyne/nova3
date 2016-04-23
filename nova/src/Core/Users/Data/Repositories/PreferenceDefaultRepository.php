<?php namespace Nova\Core\Users\Data\Repositories;

use PreferenceDefault as Model,
	PreferenceDefaultRepositoryContract;
use Nova\Core\Users\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PreferenceDefaultRepository extends BaseRepository implements PreferenceDefaultRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}
