<?php namespace Nova\Core\Pages\Api\V1\Transformers;

use Str, PageContent;
use League\Fractal\TransformerAbstract as Transformer;

class PageContentTransformer extends Transformer {

	public function transform(PageContent $content)
	{
		return [
			'id'		=> (int) $content->id,
			'key'		=> $content->key,
			'type'		=> $content->type,
			'value'		=> $content->present()->value,
			'raw'		=> $content->value,
			'preview'	=> strip_tags(Str::words($content->value, 50)),
			'protected'	=> (bool) $content->protected,
			'page'		=> [
				'id'	=> ($content->page) ? (int) $content->page->id : false,
				'name'	=> ($content->page) ? $content->page->present()->name : false,
			],
			'links'		=> [
				'edit'	=> route('admin.content.edit', [$content->id]),
			],
		];
	}

}
