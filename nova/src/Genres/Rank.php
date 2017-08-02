<?php namespace Nova\Genres;

use Eloquent;
use Nova\Characters\Character;
use Nova\Foundation\Data\Reorderable;

class Rank extends Eloquent
{
	use Reorderable;

	protected $table = 'ranks';
	protected $fillable = ['base', 'overlay', 'order', 'group_id', 'info_id'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function characters()
	{
		return $this->hasMany(Character::class);
	}

	public function group()
	{
		return $this->belongsTo(RankGroup::class, 'group_id');
	}

	public function info()
	{
		return $this->belongsTo(RankInfo::class, 'info_id');
	}
}
