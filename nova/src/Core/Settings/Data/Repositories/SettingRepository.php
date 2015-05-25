<?php namespace Nova\Core\Settings\Data\Repositories;

use Setting as Model,
	SettingRepositoryInterface;
use Illuminate\Support\Collection;
use Nova\Foundation\Data\Repositories\BaseRepository;

class SettingRepository extends BaseRepository implements SettingRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function getAllSettings()
	{
		// Get all the settings
		$settings = $this->all();

		// An array for storing all the settings
		$items = [];

		if ($settings->count() > 0)
		{
			foreach ($settings as $s)
			{
				$items[$s->key] = $s->value;
			}
		}

		return new Collection($items);
	}

	public function getByKey($key)
	{
		return $this->getFirstBy('key', $key);
	}

	public function update(array $data)
	{
		foreach ($data as $key => $value)
		{
			// Get the setting
			$setting = $this->getFirstBy('key', $key);

			// Update the setting
			$item = $setting->fill(['value' => $value]);

			// Save the setting
			$item->save();
		}

		return true;
	}

}
