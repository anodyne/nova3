<?php namespace Nova\Foundation\Data\Repositories;

use Str,
	System as Model,
	SystemRepositoryInterface;

class SystemRepository extends BaseRepository implements SystemRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function createSystemRecord()
	{
		return $this->model->create([
			'uid'			=> $this->generateUID(false),
			'version_major'	=> config('nova.app.version.major'),
			'version_minor'	=> config('nova.app.version.minor'),
			'version_patch'	=> config('nova.app.version.patch'),
		]);
	}

	public function generateUID($updateDb = true)
	{
		// Generate a new UID
		$uid = Str::random(32);

		// Update the database if we want to do that
		if ($updateDb) return $this->update(['uid' => $uid]);

		return $uid;
	}

	public function getUID()
	{
		return $this->model->first()->uid;
	}

	public function getVersion()
	{
		$item = $this->model->first();

		return "{$item->version_major}.{$item->version_minor}.{$item->version_patch}";
	}

	public function update(array $data)
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