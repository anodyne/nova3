<?php namespace Nova\Core\Pages\Data;

use Model;
use Laracasts\Presenter\PresentableTrait;

class Page extends Model {

	use PresentableTrait;

	protected $table = 'pages';

	protected $fillable = ['collection_id', 'verb', 'name', 'key', 'uri',
		'resource', 'default_resource', 'protected', 'description'];

	protected $casts = [
		'collection_id'	=> 'integer',
		'protected'		=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Nova\Core\Pages\Data\Presenters\PagePresenter';

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
