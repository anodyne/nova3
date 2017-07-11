<?php namespace Nova\Genres;

use Eloquent;
use Nova\Foundation\Data\Reorderable;

class Department extends Eloquent
{
	use Reorderable;
	
	protected $table = 'departments';
	protected $fillable = ['name', 'description', 'parent_id', 'order'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function children()
	{
		return $this->hasMany(self::class, 'parent_id');
	}

	public function parent()
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function scopeParents($query)
	{
		return $query->whereNull('parent_id');
	}
}
