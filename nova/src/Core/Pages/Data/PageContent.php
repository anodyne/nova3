<?php namespace Nova\Core\Pages\Data;

use Model;
use Laracasts\Presenter\PresentableTrait;

class PageContent extends Model {

	use PresentableTrait;

	protected $table = 'pages_content';

	protected $fillable = ['page_id', 'type', 'key', 'value'];

	protected $casts = [
		'page_id' => 'integer',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Nova\Core\Pages\Data\Presenters\PageContentPresenter';

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function page()
	{
		return $this->belongsTo('Page');
	}
	
}
