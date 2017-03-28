<?php namespace Nova\Core\Menus\Data;

use Str;
use Page;
use Model;
use Menu as MenuModel;
use MenuItemPresenter;
use Illuminate\Support\Collection;
use Laracasts\Presenter\PresentableTrait;

class MenuItem extends Model
{
	use PresentableTrait;

	protected $table = 'menus_items';

	protected $fillable = ['menu_id', 'parent_id', 'order', 'type', 'page_id',
		'link', 'title', 'access_type', 'access', 'icon'];

	protected $casts = [
		'access'	=> 'collection',
		'menu_id'	=> 'integer',
		'parent_id'	=> 'integer',
		'order'		=> 'integer',
		'page_id'	=> 'integer',
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

	//-------------------------------------------------------------------------
	// Mutators
	//-------------------------------------------------------------------------

	public function setAccessAttribute($value)
	{
		if (is_array($value)) {
			$this->attributes['access'] = json_encode($value);
		} elseif ($value instanceof Collection) {
			$this->attributes['access'] = $value->toJson();
		} else {
			$this->attributes['access'] = $value;
		}
	}

	//-------------------------------------------------------------------------
	// Model Methods
	//-------------------------------------------------------------------------

	public function userHasAccess($user)
	{
		// If we don't have anything in the access column, we can see it
		if (empty($this->access)) {
			return true;
		}

		// If we do have something in the access column and there is no user
		// then we're dealing with an unauthenticated user who can't see it
		if ($user === null) {
			return false;
		}

		// Figure out if we're looking for a role or a permission
		$method = (Str::contains($this->access_type, 'roles')) ? 'hasRole' : 'can';
		$isStrict = (Str::contains($this->access_type, 'strict'));

		foreach ($this->access as $access) {
			if ($isStrict) {
				if (! $user->{$method}($access['key'])) {
					return false;
				}
			} else {
				if ($user->{$method}($access['key'])) {
					return true;
				}
			}
		}

		return true;
	}
}
