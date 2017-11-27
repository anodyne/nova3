<?php namespace Nova\Genres\Data;

use Nova\Genres\Rank;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class RankUpdater implements Updatable
{
	use BindsData;

	public function update($item)
	{
		$item->update($this->data);

		return $item->fresh();
	}

	public function updateAll()
	{
		foreach ($this->data as $data) {
			$item = Rank::find($data['id']);

			if ($item) {
				$item->update($data);
			}
		}
		
		return true;
	}
}
