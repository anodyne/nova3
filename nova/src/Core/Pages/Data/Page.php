<?php namespace Nova\Core\Pages\Data;

use Menu,
	Model,
	MenuItem,
	PagePresenter,
	PageContent as PageContentModel;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;

class Page extends Model {

	use PresentableTrait;

	protected $table = 'pages';

	protected $fillable = ['verb', 'name', 'key', 'uri', 'resource',
		'description', 'conditions', 'type', 'menu_id', 'access', 'access_type'];

	protected $hidden = ['created_at', 'updated_at'];

	protected $appends = ['createUrl', 'deleteUrl', 'editUrl'];

	protected $casts = [
		'protected'	=> 'boolean',
		'menu_id'	=> 'integer',
		'access'	=> 'collection',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = PagePresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function menuItems()
	{
		return $this->hasMany(MenuItem::class);
	}

	public function pageContents()
	{
		return $this->hasMany(PageContentModel::class);
	}

	//-------------------------------------------------------------------------
	// Model Scopes
	//-------------------------------------------------------------------------

	public function scopeVerb($query, $verb)
	{
		$query->where('verb', '=', strtoupper($verb));
	}

	//-------------------------------------------------------------------------
	// Model Accessors
	//-------------------------------------------------------------------------

	public function getCreateUrlAttribute()
	{
		return route('admin.pages.create');
	}

	public function getDeleteUrlAttribute()
	{
		return route('admin.pages.remove', [$this->id]);
	}

	public function getEditUrlAttribute()
	{
		return route('admin.pages.edit', [$this->id]);
	}

	//-------------------------------------------------------------------------
	// Mutators
	//-------------------------------------------------------------------------

	public function setAccessAttribute($value)
	{
		if (is_array($value))
		{
			$this->attributes['access'] = json_encode($value);
		}
		elseif ($value instanceof Collection)
		{
			$this->attributes['access'] = $value->toJson();
		}
		else
		{
			$this->attributes['access'] = $value;
		}
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function content($key)
	{
		return $this->pageContents->filter(function ($c) use ($key)
		{
			return $c->key == $key;
		})->first();
	}

	public function header()
	{
		return $this->pageContents->filter(function ($c)
		{
			return $c->type == 'header';
		})->first();
	}

	public function message()
	{
		return $this->pageContents->filter(function ($c)
		{
			return $c->type == 'message';
		})->first();
	}

	public function title()
	{
		return $this->pageContents->filter(function ($c)
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
