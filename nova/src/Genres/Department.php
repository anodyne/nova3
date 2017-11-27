<?php namespace Nova\Genres;

use Eloquent;
use Nova\Foundation\Data\Reorderable;

class Department extends Eloquent
{
	use Reorderable;
	
	protected $table = 'departments';
	protected $fillable = ['name', 'description', 'parent_id', 'order', 'display'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function parent()
	{
		return $this->belongsTo(self::class, 'parent_id');
	}

	public function positions()
	{
		return $this->hasMany(Position::class, 'department_id')
			->where('display', (int) true)
			->orderBy('order');
	}

	public function subDepartments()
	{
		return $this->hasMany(self::class, 'parent_id')
			->where('display', (int) true)
			->orderBy('order');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function scopeParents($query)
	{
		return $query->whereNull('parent_id');
	}
}
