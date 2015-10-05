<?php namespace Nova\Core\Menus\Data;

use Str,
	Page,
	Model,
	MenuPresenter,
	MenuItem as MenuItemModel;
use Laracasts\Presenter\PresentableTrait;

class Menu extends Model {

	use PresentableTrait;

	protected $table = 'menus';

	protected $fillable = ['name', 'key'];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = MenuPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function menuItems()
	{
		return $this->hasMany(MenuItem::class);
	}

	public function pages()
	{
		return $this->hasMany(Page::class);
	}

	//-------------------------------------------------------------------------
	// Getters/Setters
	//-------------------------------------------------------------------------

	public function setKeyAttribute($value)
	{
		$this->attributes['key'] = (empty($value))
			? Str::slug($this->attributes['name'])
			: $value;
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function getMainMenuItems()
	{
		return $this->menuItems->filter(function($m)
		{
			return (int) $m->parent_id === 0;
		});
	}

	public function getSubMenuItems()
	{
		return $this->menuItems->filter(function($m)
		{
			return (int) $m->parent_id > 0;
		});
	}
	
}
