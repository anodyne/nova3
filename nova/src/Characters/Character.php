<?php namespace Nova\Characters;

use Eloquent;
use Nova\Users\User;
use Nova\Media\Data\HasMedia;
use Nova\Foundation\Data\HasStatus;
use Laracasts\Presenter\PresentableTrait;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Eloquent
{
	use PresentableTrait, SoftDeletes, HasMedia, HasStatus, LogsActivity;

	protected $appends = [
		'avatarImage', 'isPrimaryCharacter', 'primaryPosition', 'displayName'
	];
	protected $fillable = ['name', 'user_id', 'rank_id', 'status'];
	protected $presenter = Presenters\CharacterPresenter::class;
	protected $table = 'characters';
	protected $with = ['media', 'rank.info'];

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
		return $this->belongsTo(User::class);
	}

	//--------------------------------------------------------------------------
	// Model Methods
	//--------------------------------------------------------------------------

	public function assignToUser(User $user)
	{
		$this->user()->associate($user);

		$this->save();

		if ($this->user->fresh()->primaryCharacter === null) {
			$this->setAsPrimaryCharacter();
		}

		return $this;
	}

	public function getAvatarImageAttribute()
	{
		return $this->present()->avatarImage;
	}

	public function getDisplayNameAttribute()
	{
		return $this->present()->name;
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

		return $this;
	}

	public function unassignFromUser()
	{
		$user = $this->user;
		$wasPrimaryCharacter = $this->isPrimaryCharacter();

		$this->user()->dissociate();

		$this->save();

		if ($wasPrimaryCharacter) {
			$user->fresh()->setPrimaryCharacter();
		}

		return $this;
	}

	//--------------------------------------------------------------------------
	// Activity Logging
	//--------------------------------------------------------------------------

	protected static $logAttributes = ['name', 'rank_id', 'status'];

	public function getDescriptionForEvent(string $eventName): string
	{
		return "Character :subject.name was {$eventName}";
	}

	public function getLogNameToUse(string $eventName = ''): string
	{
		return 'nova-characters';
	}
}
