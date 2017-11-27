<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Genres\RankGroup;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Duplicatable;

class RankGroupDuplicator implements Duplicatable
{
	use BindsData;

	public function duplicate($group)
	{
		// Grab the data we want from the request
		$data = $this->data;
		
		// Replicate the original group
		$newGroup = $group->replicate();

		// Fill with the values and save it
		$newGroup->fill($data)->save();

		// Go through the ranks and duplicate them
		$group->ranks->each(function ($rank) use ($newGroup, $data) {
			duplicator(Rank::class)
				->with(array_merge(['group_id' => $newGroup->id], $data))
				->duplicate($rank);
		});

		return $newGroup;
	}
}
