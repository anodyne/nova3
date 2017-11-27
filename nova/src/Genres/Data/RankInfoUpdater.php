<?php namespace Nova\Genres\Data;

use Nova\Genres\RankInfo;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class RankInfoUpdater implements Updatable
{
	use BindsData;

	public function update($info)
	{
		$info->update($this->data);

		return $info->fresh();
	}

	public function updateAll()
	{
		foreach ($this->data as $data) {
			$info = RankInfo::find($data['id']);

			if ($info) {
				$info->update($data);
			}
		}
		
		return true;
	}
}
