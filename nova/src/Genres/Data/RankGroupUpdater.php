<?php namespace Nova\Genres\Data;

use Nova\Genres\RankGroup;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class RankGroupUpdater implements Updatable
{
	use BindsData;

	public function update($group)
	{
		$group->update($this->data);

		return $group->fresh();
	}

	public function updateAll()
	{
		// dd('updateAll', $this->data);
		foreach ($this->data as $data) {
			$group = RankGroup::find($data['id']);

			if ($group) {
				$group->update($data);
			}
		}
		
		return true;
	}
}
