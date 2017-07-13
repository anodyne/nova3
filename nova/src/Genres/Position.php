<?php namespace Nova\Genres;

use Eloquent;
use Nova\Foundation\Data\Reorderable;

class Position extends Eloquent
{
	use Reorderable;
	
	protected $table = 'positions';
	protected $fillable = ['name', 'description', 'department_id', 'order'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function department()
	{
		return $this->belongsTo(Department::class);
	}
}
