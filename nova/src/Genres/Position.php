<?php namespace Nova\Genres;

use Eloquent;
use Nova\Characters\Character;
use Nova\Foundation\Data\Reorderable;

class Position extends Eloquent
{
	use Reorderable;

	protected $table = 'positions';
	protected $fillable = [
		'name', 'description', 'department_id', 'order', 'display', 'available',
	];
	protected $casts = [
		'available' => 'string'
	];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function characters()
	{
		// return $this->hasMany(Character::class)->orderBy('name');
		return $this->belongsToMany(Character::class, 'characters_positions')
			->orderBy('name');
	}

	public function department()
	{
		return $this->belongsTo(Department::class);
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function addAvailableSlot()
	{
		$this->increment('available');

		return $this;
	}

	public function removeAvailableSlot()
	{
		if ($this->available > 0) {
			$this->decrement('available');
		}

		return $this;
	}
}
