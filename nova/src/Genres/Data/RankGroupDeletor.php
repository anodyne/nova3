<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Deletable;

class RankGroupDeletor implements Deletable
{
	use BindsData;

	public function delete($group)
	{
		// Delete any ranks in the group
		$group->ranks->each(function ($rank) {
			deletor(Rank::class)->delete($rank);
		});

		// Delete the rank group
		$group->delete();

		return $group;
	}
}
