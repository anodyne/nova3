<?php namespace Nova\Genres\Data;

use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RankGroupDeletor implements Deletable
{
	use BindsData;

	public function delete($group)
	{
		// Delete the rank group
		$group->delete();

		return $group;
	}
}
