<?php namespace Nova\Core\Repositories\Eloquent;

use Settings;
use SecurityTrait;
use SettingsRepositoryInterface;

class SettingsRepository implements SettingsRepositoryInterface {

	use SecurityTrait;

	public function all()
	{
		return Settings::all();
	}

	public function create(array $data)
	{
		return Settings::create($data);
	}

	public function delete($id)
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

		return Settings::find($id);
	}

	public function findByKey($key)
	{
		return Settings::getSettings($key);
	}

	public function update($id, array $data)
	{
		$id = $this->sanitizeInt($id);

		// Get the content item
		$item = $this->find($id);

		if ($item)
			return $item->update($data);

		return false;
	}

}