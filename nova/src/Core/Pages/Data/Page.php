<?php namespace Nova\Core\Pages\Data;

use Menu,
	Model,
	MenuItem,
	PagePresenter,
	PageContent as PageContentModel;
use Laracasts\Presenter\PresentableTrait;

class Page extends Model {

	use PresentableTrait;

	protected $table = 'pages';

	protected $fillable = ['verb', 'name', 'key', 'uri', 'resource',
		'description', 'conditions', 'type', 'menu_id'];

	protected $casts = [
		'protected'	=> 'boolean',
		'menu_id'	=> 'integer',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = PagePresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function pageContents()
	{
		return $this->hasMany(PageContentModel::class);
	}

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function menuItems()
	{
		return $this->hasMany(MenuItem::class);
	}

	//-------------------------------------------------------------------------
	// Model Scopes
	//-------------------------------------------------------------------------

	public function scopeVerb($query, $verb)
	{
		$query->where('verb', '=', strtoupper($verb));
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

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

	public function allContent()
	{
		$collection = $this->newCollection();

		foreach ($this->pageContents as $content)
		{
			$collection->put($content->key, $content->present()->value);
		}

		return $collection;
	}
	
}
