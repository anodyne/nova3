<?php namespace Nova\Settings\Data;

use Nova\Settings\Settings;
use Nova\Foundation\Data\BindsData;
use Nova\Foundation\Data\Updatable;

class SettingsUpdater implements Updatable
{
	use BindsData;

	public function update($department)
	{
		$department->update($this->data);

		return $department->fresh();
	}

	public function updateAll()
	{
		foreach ($this->data as $key => $value) {
			Settings::item($key)->update(['value' => $value]);
		}
	}
}
