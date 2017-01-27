<?php namespace Nova\Core\Pages\Data\Repositories;

use Page as Model,
	PageRepositoryContract,
	PageContentRepositoryContract;
use Nova\Core\Pages\Events;
use Illuminate\Routing\Route;
use Nova\Foundation\Data\Repositories\BaseRepository;

class PageRepository extends BaseRepository implements PageRepositoryContract {

	protected $model;
	protected $contentRepo;

	public function __construct(Model $model,
			PageContentRepositoryContract $content)
	{
		$this->model = $model;
		$this->contentRepo = $content;
	}

	public function all(array $with = [], $verb = false)
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
		if ($data['type'] == 'basic')
		{
			unset($data['verb']);
			unset($data['resource']);
			unset($data['conditions']);
		}

		if ($data['type'] == 'advanced')
		{
			unset($data['access_type']);
			unset($data['access']);
		}

		// Create the page
		$page = $this->model->create($data);

		// Set which content items we want to create
		$contentToCreate = ['title', 'header', 'message'];

		foreach ($contentToCreate as $type)
		{
			// Create the new content item
			$newContentItem = $this->contentRepo->create([
				'type'	=> $type,
				'key'	=> "{$page->key}.{$type}",
				'value' => (array_key_exists('content', $data) and array_key_exists($type, $data['content']))
					? $data['content'][$type] 
					: null,
			]);

			// Attach the content record to the page
			$page->pageContents()->save($newContentItem);
		}

		event(new Events\PageCreated($page));

		return $page;
	}

	public function delete($resource)
	{
		// Get the page
		$page = $this->getResource($resource);

		if ($page)
		{
			if ($page->pageContents->count() > 0)
			{
				foreach ($page->pageContents as $content)
				{
					// Remove the content
					$this->contentRepo->delete($content->id);
				}
			}

			// Remove the page
			$page->delete();

			event(new Events\PageDeleted($page->name, $page->key, $page->uri));

			return $page;
		}

		return false;
	}

	public function find($id)
	{
		return $this->getById($id, ['pageContents']);
	}

	public function getByRouteKey($route, $with = [])
	{
		$routeName = ($route instanceof Route) ? $route->getName() : $route;

		// If we only have 1 argument for the method, we'll assume that we
		// want to pull all of the relationships. Otherwise, we want to
		// either pull no relationships or just the ones we pass over
		if (func_num_args() == 1)
		{
			$relations = ['pageContents', 'menu', 'menu.pages', 'menu.menuItems', 'menu.menuItems.page'];
		}
		else
		{
			$relations = (is_array($with)) ? $with : [];
		}

		return $this->getFirstBy('key', $routeName, $relations);
	}

	public function getByRouteUri($route, $with = [])
	{
		$routeUri = ($route instanceof Route) ? $route->uri() : $route;

		// If we only have 1 argument for the method, we'll assume that we
		// want to pull all of the relationships. Otherwise, we want to
		// either pull no relationships or just the ones we pass over
		if (func_num_args() == 1)
		{
			$relations = ['pageContents', 'menu', 'menu.pages', 'menu.menuItems', 'menu.menuItems.page'];
		}
		else
		{
			$relations = (is_array($with)) ? $with : [];
		}

		return $this->getFirstBy('uri', $routeUri, $relations);
	}

	public function update($resource, array $data)
	{
		// Get the page
		$page = $this->getResource($resource);

		if ($page)
		{
			if ($data['type'] == 'basic')
			{
				unset($data['conditions']);
			}

			if ($data['type'] == 'advanced')
			{
				unset($data['access_type']);
				unset($data['access']);
			}
			
			// Update the page
			$page->fill($data)->save();

			// Set which content items we want to update
			$contentToUpdate = ['title', 'header', 'message'];

			foreach ($contentToUpdate as $type)
			{
				// Build the value
				$value = (array_key_exists('content', $data) and array_key_exists($type, $data['content']))
					? $data['content'][$type] 
					: null;

				// Get the content item
				$contentItem = $page->{$type}();

				if ($contentItem)
				{
					// Update the item
					$this->contentRepo->update($contentItem, ['value' => $value]);
				}
				else
				{
					// We didn't have a content item, so let's create one
					$newContentItem = $this->contentRepo->create([
						'type'	=> $type,
						'key'	=> "{$page->key}.{$type}",
						'value'	=> $value,
					]);

					// Attach the content record to the page
					$page->pageContents()->save($newContentItem);
				}
			}

			event(new Events\PageUpdated($page));

			return $page;
		}

		return false;
	}

}