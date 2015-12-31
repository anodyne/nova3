<?php namespace Nova\Core\Forms\Data\Interfaces;

use Nova\Foundation\Data\Interfaces\BaseRepositoryInterface;

interface BaseFormRepositoryInterface extends BaseRepositoryInterface {

	public function getForm($resource);

}
