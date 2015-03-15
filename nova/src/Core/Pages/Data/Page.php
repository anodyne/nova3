<?php namespace Nova\Core\Pages\Data;

use Model, PagePresenter;
use Laracasts\Presenter\PresentableTrait;

class Page extends Model {

	use PresentableTrait;

	protected $table = 'pages';

	protected $fillable = ['verb', 'name', 'key', 'uri', 'resource',
		'description', 'conditions'];

	protected $casts = [
		'collection_id'	=> 'integer',
		'protected'		=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = PagePresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function pageContents()
	{
		return $this->hasMany('PageContent');
	}

	/*
	|---------------------------------------------------------------------------
	| Models Methods
	|---------------------------------------------------------------------------
	*/

	public function content($key)
	{
		return $this->pageContents->filter(function($c) use ($key)
		{
			return $c->key == $key;
		})->first();
	}

	public function header()
	{
		return $this->pageContents->filter(function($c)
		{
			return $c->type == 'header';
		})->first();
	}

	public function message()
	{
		return $this->pageContents->filter(function($c)
		{
			return $c->type == 'message';
		})->first();
	}

	public function title()
	{
		return $this->pageContents->filter(function($c)
		{
			return $c->type == 'title';
		})->first();
	}
	
}
