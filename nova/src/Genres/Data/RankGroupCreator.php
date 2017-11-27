<?php namespace Nova\Genres\Data;

use Nova\Genres\RankGroup;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class RankGroupCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return RankGroup::create($this->data);
	}
}
