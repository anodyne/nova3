<?php namespace Nova\Api\V1\Transformers;

use Page as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class PageTransformer extends Transformer {

	public function transform(Resource $resource)
	{
		return [
			'id'			=> (int) $resource->id,
			'name'			=> $resource->name,
			'description'	=> $resource->description,
			'key'			=> $resource->key,
			'protected'		=> (bool) $resource->protected,
			'type'			=> ( ! empty($resource->resource)) ? 'advanced' : 'basic',
			'uri'			=> $resource->uri,
			'verb'			=> $resource->verb,
			'content'		=> [
				'header'		=> $resource->present()->header,
				'message'		=> $resource->present()->message,
				'title'			=> $resource->present()->title,
			],
			'links'			=> [
				'edit'			=> route('admin.pages.edit', [$resource->id]),
			],
			'resources'		=> [
				'default'		=> $resource->default_resource,
				'overridden'	=> (bool) ( ! empty($resource->resource)),
				'new'			=> $resource->resource,
			],
		];
	}

}
