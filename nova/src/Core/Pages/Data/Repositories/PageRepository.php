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

	public function countRouteKeys($key)
	{
		$keys = $this->countBy('key', $key);

		return (int) $keys;
	}

	public function create(array $data)
	{
		$page = $this->model->create($data[$data['type']]);

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

	public function getByRouteKey(Route $route)
	{
		return $this->getFirstBy('key', $route->getName(), ['pageContents']);
	}

	public function getByRouteUri(Route $route)
	{
		return $this->getFirstBy('uri', $route->getUri(), ['pageContents']);
	}

}