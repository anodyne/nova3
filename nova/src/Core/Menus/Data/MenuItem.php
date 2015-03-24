<?php namespace Nova\Core\Menus\Data;

use Model, MenuItemPresenter;
use Laracasts\Presenter\PresentableTrait;

class MenuItem extends Model {

	use PresentableTrait;

	protected $table = 'menus_items';

	protected $fillable = ['menu_id', 'parent_id', 'order', 'type', 'page_id',
		'link', 'title'];

	protected $casts = [
		'menu_id'	=> 'integer',
		'parent_id'	=> 'integer',
		'order'		=> 'integer',
		'page_id'	=> 'integer',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = MenuItemPresenter::class;

	/*
	|---------------------------------------------------------------------------
	| Relationships
	|---------------------------------------------------------------------------
	*/

	public function menu()
	{
		return $this->belongsTo('Menu');
	}
	
}
