<?php namespace Nova\Core\Repositories\Eloquent;

use UtilityTrait;
use SettingsModel;
use SecurityTrait;
use SettingsRepositoryInterface;

class SettingsRepository implements SettingsRepositoryInterface {

	use UtilityTrait;
	use SecurityTrait;

	public function all()
	{
		return SettingsModel::all();
	}

	public function create(array $data, $setFlash = true)
	{
		return SettingsModel::create($data);
	}

	public function delete($id, $setFlash = true)
	{
		$id = $this->sanitizeInt($id);

		// Get the content item
		$item = $this->find($id);

		if ($item)
			return $item->delete();

		return false;
	}

	public function find($id)
	{
		$id = $this->sanitizeInt($id);

		return SettingsModel::find($id);
	}

	public function findByKey($key)
	{
		return SettingsModel::getSettings($key);
	}

	public function update($id, array $data, $setFlash = true)
	{
		$id = $this->sanitizeInt($id);

		// Get the content item
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

}