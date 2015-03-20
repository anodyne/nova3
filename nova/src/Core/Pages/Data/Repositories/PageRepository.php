<?php namespace Nova\Core\Pages\Data\Repositories;

use Page as Model,
	PageRepositoryInterface;
use Illuminate\Routing\Route;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryInterface {

	protected $model;

	public function __construct(Model $model)
	{
		$this->model = $model;
	}

	public function all()
	{
		return $this->make(['pageContents'])->get();
	}

	public function create(array $data)
	{
		$combinedData = array_merge(['type' => $data['type']], $data[$data['type']]);

		$page = $this->model->create($combinedData);

		if (array_key_exists('content', $data))
		{
			// Grab the content repo out of the IOC
			$contentRepo = app('PageContentRepository');

			foreach ($data['content'] as $type => $value)
			{
				// Build the content data
				$content = [
					'type'	=> $type,
					'key'	=> "{$page->key}.{$type}",
					'value'	=> $value,
				];

				// Create the content item
				$contentItem = $contentRepo->create($content);

				// Attach the content record to the page
				$page->pageContents()->save($contentItem);
			}
		}

		return $page;
	}

	public function delete($id)
	{
		// Get the page
		$page = $this->find($id);

		if ($page)
		{
			// Make the content repo
			$contentRepo = app('PageContentRepository');

			if ($page->pageContents->count() > 0)
			{
				foreach ($page->pageContents as $content)
				{
					// Remove the content
					$contentRepo->delete($content->id);
				}
			}

			// Remove the page
			$page->delete();

			return $page;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['pageContents']);
	}

	public function getByRouteKey($route)
	{
		$routeName = ($route instanceof Route) ? $route->getName() : $route;

		return $this->getFirstBy('key', $routeName, ['pageContents']);
	}

	public function getByRouteUri($route)
	{
		$routeUri = ($route instanceof Route) ? $route->getUri() : $route;

		return $this->getFirstBy('uri', $routeUri, ['pageContents']);
	}

	public function update($id, array $data)
	{
		// Get the page
		$page = $this->find($id);

		if ($page)
		{
			// Update the page
			$updatedPage = $page->fill($data)->save();

			if (array_key_exists('content', $data))
			{
				// Grab the content repo out of the IOC
				$contentRepo = app('PageContentRepository');

				foreach ($data['content'] as $type => $value)
				{
					// Build the content data
					$content = [
						'type'	=> $type,
						'key'	=> "{$page->key}.{$type}",
						'value'	=> $value,
					];

					// Create the content item
					$contentItem = $contentRepo->create($content);

					// Attach the content record to the page
					$page->pageContents()->save($contentItem);
				}
			}

			return $updatedPage;
		}

		return false;
	}

}