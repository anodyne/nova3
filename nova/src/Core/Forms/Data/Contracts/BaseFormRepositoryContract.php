<?php namespace Nova\Core\Forms\Data\Contracts;

use Nova\Foundation\Data\Contracts\BaseRepositoryContract;

interface BaseFormRepositoryContract extends BaseRepositoryContract {

	public function getForm($resource);

}
