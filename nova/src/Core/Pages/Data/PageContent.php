<?php namespace Nova\Core\Pages\Data;

use Model, PageContentPresenter;
use Laracasts\Presenter\PresentableTrait;

class PageContent extends Model {

	use PresentableTrait;

	protected $table = 'pages_content';

	protected $fillable = ['page_id', 'type', 'key', 'value'];

	protected $casts = [
		'page_id'	=> 'integer',
		'protected'	=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = PageContentPresenter::class;

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
