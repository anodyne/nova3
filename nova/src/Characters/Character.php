<?php namespace Nova\Characters;

use Eloquent;
use Nova\Media\Data\HasMedia;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Eloquent
{
	use PresentableTrait, SoftDeletes, HasMedia;

	protected $table = 'characters';
	protected $fillable = ['name', 'user_id', 'rank_id', 'status'];
	protected $presenter = Presenters\CharacterPresenter::class;
	protected $with = ['media', 'rank.info'];
	protected $appends = ['avatarImage', 'isPrimaryCharacter', 'primaryPosition'];

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function positions()
	{
		return $this->belongsToMany('Nova\Genres\Position', 'characters_positions')
			->withPivot('primary');
	}

	public function rank()
	{
		return $this->belongsTo('Nova\Genres\Rank');
	}

	public function user()
	{
		return $this->belongsTo('Nova\Users\User');
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function getAvatarImageAttribute()
	{
		return $this->present()->avatarImage;
	}

	public function getIsPrimaryCharacterAttribute()
	{
		return $this->isPrimaryCharacter();
	}

	public function getPrimaryPositionAttribute()
	{
		$primary = $this->positions->filter(function ($position) {
			return $position->pivot->primary === (int) true;
		});

		if ($primary) {
			return $primary->first();
		}

		return $primary;
	}

	public function isPrimaryCharacter()
	{
		if ($this->user) {
			return $this->user->primary_character == $this->id;
		}

		return false;
	}

	public function setAsPrimaryCharacter()
	{
		if ($this->user) {
			$this->user->setPrimaryCharacterAs($this);
		}
	}
}
