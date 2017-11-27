<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class RankCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return Rank::create($this->data);
	}
}
