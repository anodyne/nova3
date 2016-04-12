<?php namespace Nova\Api\V1\Transformers;

use Str,
	PageContent as Resource;
use League\Fractal\TransformerAbstract as Transformer;

class PageContentTransformer extends Transformer {

	public function transform(Resource $resource)
	{
		return [
			'id'		=> (int) $resource->id,
			'key'		=> $resource->key,
			'type'		=> $resource->type,
			'value'		=> $resource->present()->value,
			'raw'		=> $resource->value,
			'preview'	=> strip_tags(Str::words($resource->value, 50)),
			'protected'	=> (bool) $resource->protected,
			'page'		=> [
				'id'	=> ($resource->page) ? (int) $resource->page->id : false,
				'name'	=> ($resource->page) ? $resource->page->present()->name : false,
			],
			'links'		=> [
				'edit'	=> route('admin.content.edit', [$resource->id]),
			],
		];
	}

}
