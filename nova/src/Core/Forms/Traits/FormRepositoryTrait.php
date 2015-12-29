<?php namespace Nova\Core\Forms\Traits;

trait FormRepositoryTrait {

	public function getForm($resource)
	{
		return $resource->form;
	}

}
