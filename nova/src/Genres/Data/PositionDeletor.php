<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class PositionDeletor implements Deletable
{
	use BindsData;

	public function delete($position)
	{
		// Delete the position
		$position->delete();

		return $position;
	}
}
