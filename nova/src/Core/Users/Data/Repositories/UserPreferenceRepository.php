<?php namespace Nova\Core\Users\Data\Repositories;

use UserPreference as Model,
	UserPreferenceRepositoryContract;
use Nova\Core\Users\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class UserPreferenceRepository extends BaseRepository implements UserPreferenceRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

}
