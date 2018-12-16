<?php

namespace Nova\Pages;

use Nova\Content\Contentable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	use Contentable;

	protected $dispatchesEvents = [
		'saved' => Events\PageSaved::class
	];

	protected $fillable = [
		'name', 'key', 'uri', 'layout', 'content_template', 'verb', 'resource'
	];

	/**
	 * Get the content template path for this page.
	 *
	 * @return string
	 */
	public function getContentTemplate()
	{
		return sprintf('templates.%s', $this->content_template);
	}
}
