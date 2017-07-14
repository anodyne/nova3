<?php namespace Nova\Genres\Data;

use Nova\Genres\Position;
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

	public function updateAll()
	{
		// dd('updateAll', $this->data);
		foreach ($this->data as $data) {
			$position = Position::find($data['id']);

			if ($position) {
				$position->update($data);
			}
		}
		
		return true;
	}
}
