<?php namespace Nova\Core\Pages\Data\Repositories;

use PageContent as Model,
	PageContentRepositoryInterface;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageContentRepository extends BaseRepository implements PageContentRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return $this->make(['page'])->get();
	}

	public function create(array $data)
	{
		return $this->model->create($data);
	}

	public function delete($id)
	{
		// Get the content
		$content = $this->getById($id);

		if ($content)
		{
			// Delete the content
			$content->delete();

			return $content;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['page']);
	}

	public function update($item, array $data)
	{
		$content = ($item instanceof Model) ? $item : $this->getById($item);

		if ($content)
		{
			// Fill and save the content
			$updatedContentItem = $content->fill($data);
			$updatedContentItem->save();

			return $updatedContentItem;
		}

		return false;
	}

}
