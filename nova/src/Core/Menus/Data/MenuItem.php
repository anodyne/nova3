<?php namespace Nova\Core\Menus\Data;

use Page,
	Model,
	Menu as MenuModel,
	MenuItemPresenter;
use Laracasts\Presenter\PresentableTrait;

class MenuItem extends Model {

	use PresentableTrait;

	protected $table = 'menus_items';

	protected $fillable = ['menu_id', 'parent_id', 'order', 'type', 'page_id',
		'link', 'title', 'authentication'];

	protected $casts = [
		'menu_id'			=> 'integer',
		'parent_id'			=> 'integer',
		'order'				=> 'integer',
		'page_id'			=> 'integer',
		'authentication'	=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = MenuItemPresenter::class;

	//-------------------------------------------------------------------------
	// Relationships
	//-------------------------------------------------------------------------

	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function page()
	{
		return $this->belongsTo(Page::class);
	}

	public function childrenMenuItems()
	{
		return $this->hasMany(self::class, 'parent_id', 'id');
	}

	public function parentMenuItem()
	{
		return $this->belongsTo(self::class, 'parent_id', 'id');
	}
	
}
