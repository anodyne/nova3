<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class PositionUpdater implements Updatable
{
	use BindsData;

	public function update($position)
	{
		$position->update($this->data);

		return $position->fresh();
	}
}
