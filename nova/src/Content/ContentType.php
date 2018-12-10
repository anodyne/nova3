<?php

namespace Nova\Content;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentType extends Model
{
	use SoftDeletes;

    protected $fillable = ['key', 'name'];
	protected $table = 'content_types';

	/**
	 * Get the content models for this content type/
	 *
	 * @return \Illuminate\Database\Eloquent\Collection
	 */
	public function content()
	{
		return $this->hasMany(Content::class, 'type_id');
	}
}
