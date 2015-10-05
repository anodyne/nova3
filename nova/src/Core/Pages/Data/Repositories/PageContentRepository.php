<?php namespace Nova\Core\Pages\Data\Repositories;

use PageContent as Model,
	PageContentRepositoryInterface;
use Illuminate\Support\Collection;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageContentRepository extends BaseRepository implements PageContentRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all(array $with = ['page'])
	{
		return $this->make($with)->get();
	}

	public function allExcept(array $except)
	{
		// Get everything first
		$content = $this->all();

		if ($content)
		{
			return $content->filter(function($c) use ($except)
			{
				return ! in_array($c->type, $except);
			});
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['page']);
	}

	public function getAllContent()
	{
		// Get all the content
		$content = $this->all([]);

		// An array for storing all the content
		$items = [];

		if ($content->count() > 0)
		{
			foreach ($content as $c)
			{
				$items[$c->key] = $c->value;
			}
		}

		return new Collection($items);
	}

	public function getByKey($key, array $with = [])
	{
		// If we only have 1 argument for the method, we'll assume that we
		// want to pull all of the relationships. Otherwise, we want to
		// either pull no relationships or just the ones we pass over
		if (func_num_args() == 1)
		{
			$relations = ['page'];
		}
		else
		{
			$relations = (is_array($with)) ? $with : [];
		}

		return $this->getFirstBy('key', $key, $relations);
	}

	public function updateByKey(array $data)
	{
		foreach ($data as $key => $value)
		{
			// Get the content item with the key
			$content = $this->getByKey($key, []);

			if ($content)
			{
				$this->update($content, ['value' => $value]);
			}
		}

		return true;
	}

}
