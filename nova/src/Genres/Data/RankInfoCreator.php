<?php namespace Nova\Genres\Data;

use Nova\Genres\RankInfo;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class RankInfoCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return RankInfo::create($this->data);
	}
}
