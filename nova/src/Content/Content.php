<?php

namespace Nova\Content;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
	protected $fillable = ['type_id', 'order', 'content'];
	protected $table = 'content';
	protected $with = ['type'];

	/**
	 * Get the contentable model.
	 *
	 * @return mixed
	 */
	public function contentable()
	{
		return $this->morphTo();
	}

	/**
	 * Get the content type of the model.
	 *
	 * @return \Nova\Content\ContentType
	 */
	public function type()
	{
		return $this->belongsTo(ContentType::class, 'type_id');
	}

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
