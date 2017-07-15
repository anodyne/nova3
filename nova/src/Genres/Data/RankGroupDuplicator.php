<?php namespace Nova\Genres\Data;

use Nova\Genres\RankGroup;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Duplicatable;

class RankGroupDuplicator implements Duplicatable
{
	use BindsData;

	public function duplicate($group)
	{
		// Replicate the original group
		$newGroup = $group->replicate();

		// Fill with the values and save it
		$newGroup->fill($this->data)->save();

		return $newGroup;
	}
}
