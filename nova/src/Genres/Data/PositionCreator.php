<?php namespace Nova\Genres\Data;

use Nova\Genres\Position;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Creatable;

class PositionCreator implements Creatable
{
	use BindsData;

	public function create()
	{
		return Position::create($this->data);
	}
}
