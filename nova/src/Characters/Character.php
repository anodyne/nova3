<?php namespace Nova\Characters;

use Eloquent;
use Nova\Users\User;
use Nova\Genres\Rank;
use Nova\Genres\Position;
use Nova\Foundation\Media;
use Laracasts\Presenter\PresentableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Character extends Eloquent
{
	use PresentableTrait, SoftDeletes;

	protected $table = 'characters';
	protected $fillable = ['name', 'user_id', 'position_id', 'rank_id', 'status'];
	protected $presenter = Presenters\CharacterPresenter::class;

	//--------------------------------------------------------------------------
	// Relationships
	//--------------------------------------------------------------------------

	public function media()
	{
		return $this->morphMany(Media::class, 'mediable');
	}

	public function position()
	{
		return $this->belongsTo(Position::class);
	}

	public function rank()
	{
		return $this->belongsTo(Rank::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
