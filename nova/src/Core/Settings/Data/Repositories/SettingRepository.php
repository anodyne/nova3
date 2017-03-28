<?php namespace Nova\Core\Settings\Data\Repositories;

use Setting as Model;
use SettingRepositoryContract;
use Nova\Core\Settings\Events;
use Nova\Foundation\Data\Repositories\BaseRepository;

class SettingRepository extends BaseRepository implements SettingRepositoryContract
{
	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		$setting = $this->model->create($data);

		// event

		return $setting;
	}

	public function getAllSettings()
	{
		return $this->all()->mapWithKeys(function ($item) {
			return [$item->key => $item->value];
		});
	}

	public function getByKey($key)
	{
		return $this->getFirstBy('key', $key);
	}

	public function updateByKey(array $data)
	{
		foreach ($data as $key => $value) {
			// Get the setting
			$setting = $this->getFirstBy('key', $key);

			if ($setting) {
				// Update the setting
				$item = $setting->fill(['value' => $value]);

				// Save the setting
				$item->save();
			}
		}

		// event

		return true;
	}
}
