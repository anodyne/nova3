<?php

namespace Nova\Content;

trait Contentable
{
	/**
	 * Get all the content for the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function content()
	{
		return $this->morphMany(Content::class, 'contentable');
	}

	/**
	 * Get a specific piece of content by its type. If there is only one record
	 * it will return just that Content model, otherwise, it will return the
	 * full Collection of models.
	 *
	 * @param  string  $type
	 * @return \Illuminate\Database\Eloquent\Collection|\Nova\Content\Content
	 */
	public function getContentByType($type)
	{
		$content = $this->content()->get()->where('type.key', $type);

		if ($content->count() === 1) {
			return $content->first();
		}

		return $content;
	}
}
