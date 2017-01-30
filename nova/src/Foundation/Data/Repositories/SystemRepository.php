<?php namespace Nova\Foundation\Data\Repositories;

use Str,
	System as Model,
	SystemRepositoryContract;
use Ramsey\Uuid\Uuid;

class SystemRepository extends BaseRepository implements SystemRepositoryContract {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function createSystemRecord()
	{
		return $this->model->create([
			'uuid'			=> $this->generateUUID(false),
			'version_major'	=> config('nova.app.version.major'),
			'version_minor'	=> config('nova.app.version.minor'),
			'version_patch'	=> config('nova.app.version.patch'),
		]);
	}

	public function generateUUID($updateDb = true)
	{
		$uuid = Uuid::uuid4();

		// Update the database if we want to do that
		if ($updateDb)
		{
			return $this->update(['uuid' => $uuid]);
		}

		return $uuid;
	}

	public function getAllInfo()
	{
		return $this->model->first();
	}

	public function getUUID()
	{
		return $this->model->first()->uuid;
	}

	public function getVersion()
	{
		$item = $this->model->first();

		return "{$item->version_major}.{$item->version_minor}.{$item->version_patch}";
	}

	public function updateSystemRecord(array $data)
	{
		$info = $this->model->first();

		if ($info)
		{
			// Fill the data
			$item = $info->fill($data);

			// Save the item
			$item->save();

			return $item;
		}

		return false;
	}
}
