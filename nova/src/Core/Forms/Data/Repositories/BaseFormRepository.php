<?php namespace Nova\Core\Forms\Data\Repositories;

use Nova\Foundation\Data\Repositories\BaseRepository,
	Nova\Core\Forms\Data\Interfaces\BaseFormRepositoryInterface;

abstract class BaseFormRepository extends BaseRepository implements BaseFormRepositoryInterface {

	public function getForm($resource)
	{
		$item = $this->getResource($resource);

		if ($item->has('form'))
		{
			return $item->form;
		}

		throw new RuntimeException("The specified resource does not have a form relationship.");
	}
	
}
