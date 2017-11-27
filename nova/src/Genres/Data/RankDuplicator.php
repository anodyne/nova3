<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Duplicatable;

class RankDuplicator implements Duplicatable
{
	use BindsData;

	public function duplicate($item)
	{
		// Replicate the original item
		$newItem = $item->replicate();

		// Fill with the values and save it
		$newItem->fill($this->data)->save();

		return $newItem;
	}
}
