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

	public function all($verb = false)
	{
		$query = $this->make(['pageContents']);

		if ($verb)
		{
			$query = $query->verb($verb);
		}

		return $query->get();
	}

	public function create(array $data)
	{
		// Combine the data
		$combinedData = array_merge(['type' => $data['type']], $data[$data['type']]);

		// Create the page
		$page = $this->model->create($combinedData);

		// Set which content items we want to create
		$contentToCreate = ['title', 'header', 'message'];

		// Grab the content repo out of the IOC
		$contentRepo = app('PageContentRepository');

		foreach ($contentToCreate as $type)
		{
			// Create the new content item
			$newContentItem = $contentRepo->create([
				'type'	=> $type,
				'key'	=> "{$page->key}.{$type}",
				'value' => (array_key_exists('content', $data) and array_key_exists($type, $data['content']))
					? $data['content'][$type] 
					: null,
			]);

			// Attach the content record to the page
			$page->pageContents()->save($newContentItem);
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
			$updatedPage = $page->fill($data);
			$updatedPage->save();

			// Set which content items we want to update
			$contentToUpdate = ['title', 'header', 'message'];

			// Grab the content repo out of the IOC
			$contentRepo = app('PageContentRepository');

			foreach ($contentToUpdate as $type)
			{
				// Build the value
				$value = (array_key_exists('content', $data) and array_key_exists($type, $data['content']))
					? $data['content'][$type] 
					: null;

				// Get the content item
				$contentItem = $updatedPage->{$type}();

				if ($contentItem)
				{
					// Update the item
					$contentRepo->update($contentItem, ['value' => $value]);
				}
				else
				{
					// We didn't have a content item, so let's create one
					$newContentItem = $contentRepo->create([
						'type'	=> $type,
						'key'	=> "{$updatedPage->key}.{$type}",
						'value'	=> $value,
					]);

					// Attach the content record to the page
					$updatedPage->pageContents()->save($newContentItem);
				}
			}

			return $updatedPage;
		}

		return false;
	}

}