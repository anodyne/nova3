<?php namespace Nova\Core\Pages\Api\V1\Transformers;

use Page;
use League\Fractal\TransformerAbstract as Transformer;

class PageTransformer extends Transformer {

	public function transform(Page $page)
	{
		return [
			'id'			=> (int) $page->id,
			'name'			=> $page->name,
			'description'	=> $page->description,
			'key'			=> $page->key,
			'protected'		=> (bool) $page->protected,
			'type'			=> ( ! empty($page->resource)) ? 'advanced' : 'basic',
			'uri'			=> $page->uri,
			'verb'			=> $page->verb,
			'content'		=> [
				'header'		=> $page->present()->header,
				'message'		=> $page->present()->message,
				'title'			=> $page->present()->title,
			],
			'links'			=> [
				'edit'			=> route('admin.pages.edit', [$page->id]),
			],
			'resources'		=> [
				'default'		=> $page->default_resource,
				'overridden'	=> (bool) ( ! empty($page->resource)),
				'new'			=> $page->resource,
			],
		];
	}

}
