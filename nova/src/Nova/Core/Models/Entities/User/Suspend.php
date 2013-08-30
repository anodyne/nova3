<?php namespace Nova\Core\Models\Entities\User;

use Date;
use Model;
use Cartalyst\Sentry\Throttling\ThrottleInterface;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;

class Suspend extends Model implements ThrottleInterface {

	protected $table = 'user_suspended';

	protected $fillable = array(
		'user_id', 'suspended', 'banned', 'last_attempt_at', 'suspended_at',
	);

	protected static $properties = array(
		'id', 'user_id', 'suspended', 'banned', 'last_attempt_at', 'suspended_at',
	);

	/**
	 * Attempt limit.
	 *
	 * @var int
	 */
	protected $attemptLimit = 5;

	/**
	 * Suspensions time in minutes.
	 *
	 * @var int
	 */
	protected $suspensionTime = 15;

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Throttling status.
	 *
	 * @var bool
	 */
	protected $enabled = true;

	/**
	 * The date fields for the model.
	 *
	 * @var array
	 */
	protected $dates = array('last_attempt_at', 'suspended_at');

	/**
	 * Belongs To: User
	 */
	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/*
	|--------------------------------------------------------------------------
	| Sentry Throttling Interface Methods
	|--------------------------------------------------------------------------
	|
	| Sentry provides an interface of methods that need to be implemented by
	| the model. In Nova's case, some of these aren't applicable, and in those
	| situations, we simply throw exceptions. In others, we do things the way
	| we've chosen to setup our authorization system.
	|
	*/

	/**
	 * Returns the associated user with the throttler.
	 *
	 * @return	Cartalyst\Sentry\Users\UserInterface
	 */
	public function getUser()
	{
		return $this->user;
	}

	/**
	 * Set attempt limit.
	 *
	 * @param	int		Attempt limit
	 * @return	void
	 */
	public function setAttemptLimit($limit)
	{
		$this->attemptLimit = (int) $limit;
	}

	/**
	 * Get attempt limit.
	 *
	 * @return	int
	 */
	public function getAttemptLimit()
	{
		return $this->attemptLimit;
	}

	/**
	 * Set suspension time.
	 *
	 * @param	int		Time in minutes a suspension lasts
	 * @return	void
	 */
	public function setSuspensionTime($minutes)
	{
		$this->suspensionTime = (int) $minutes;
	}

	/**
	 * Get suspension time.
	 *
	 * @param  int
	 */
	public function getSuspensionTime()
	{
		return $this->suspensionTime;
	}

	/**
	 * Get the current amount of attempts.
	 *
	 * @return	int
	 */
	public function getLoginAttempts()
	{
		if ($this->attempts > 0 and $this->last_attempt_at)
		{
			$this->clearLoginAttemptsIfAllowed();
		}

		return $this->attempts;
	}

	/**
	 * Add a new login attempt.
	 *
	 * @return	void
	 */
	public function addLoginAttempt()
	{
		// Increment the attempts
		++$this->attempts;

		// Set a new timestamp
		$this->last_attempt_at = $this->freshTimeStamp();

		if ($this->getLoginAttempts() >= $this->attemptLimit)
		{
			$this->suspend();
		}
		else
		{
			$this->save();
		}
	}

	/**
	 * Clear all login attempts
	 *
	 * @return	void
	 */
	public function clearLoginAttempts()
	{
		if ($this->getLoginAttempts() == 0 or $this->suspended)
		{
			return;
		}

		$this->attempts = 0;
		$this->last_attempt_at = null;
		$this->suspended = false;
		$this->suspended_at = null;
		$this->save();
	}

	/**
	 * Suspend the user associated with the throttle
	 *
	 * @return	void
	 */
	public function suspend()
	{
		if ( ! $this->suspended)
		{
			$this->suspended = true;
			$this->suspended_at = $this->freshTimeStamp();
			$this->save();
		}
	}

	/**
	 * Unsuspend the user.
	 *
	 * @return void
	 */
	public function unsuspend()
	{
		if ($this->suspended)
		{
			$this->attempts = 0;
			$this->last_attempt_at = null;
			$this->suspended = false;
			$this->suspended_at = null;
			$this->save();
		}
	}

	/**
	 * Check if the user is suspended.
	 *
	 * @return	bool
	 */
	public function isSuspended()
	{
		if ($this->suspended and $this->suspended_at)
		{
			$this->removeSuspensionIfAllowed();
			return (bool) $this->suspended;
		}

		return false;
	}

	/**
	 * Ban the user.
	 *
	 * @return	void
	 */
	public function ban()
	{
		if ( ! $this->banned)
		{
			$this->banned = true;
			$this->save();
		}
	}

	/**
	 * Unban the user.
	 *
	 * @return	void
	 */
	public function unban()
	{
		if ($this->banned)
		{
			$this->banned = false;
			$this->save();
		}
	}

	/**
	 * Check if user is banned
	 *
	 * @return	bool
	 */
	public function isBanned()
	{
		return $this->banned;
	}

	/**
	 * Check user throttle status.
	 *
	 * @return	bool
	 * @throws	Cartalyst\Sentry\Throttling\UserBannedException
	 * @throws	Cartalyst\Sentry\Throttling\UserSuspendedException
	 */
	public function check()
	{
		if ($this->isBanned())
		{
			throw new UserBannedException(sprintf(
				'User [%s] has been banned.',
				$this->getUser()->getLogin()
			));
		}

		if ($this->isSuspended())
		{
			throw new UserSuspendedException(sprintf(
				'User [%s] has been suspended.',
				$this->getUser()->getLogin()
			));
		}

		return true;
	}

	/**
	 * Inspects the last attempt vs the suspension time (the time in which
	 * attempts must space before the account is suspended). If we can clear our
	 * attempts now, we'll do so and save.
	 *
	 * @return	void
	 */
	public function clearLoginAttemptsIfAllowed()
	{
		$lastAttempt = clone($this->last_attempt_at);
		$clearAttemptsAt = $lastAttempt->modify("+{$this->suspensionTime} minutes");
		$now = Date::now('UTC');

		if ($clearAttemptsAt <= $now)
		{
			$this->attempts = 0;
			$this->save();
		}

		unset($lastAttempt);
		unset($clearAttemptsAt);
		unset($now);
	}

	/**
	 * Inspects to see if the user can become unsuspended or not, based on the
	 * suspension time provided. If so, unsuspends.
	 *
	 * @return	void
	 */
	public function removeSuspensionIfAllowed()
	{
		$suspended = clone($this->suspended_at);
		$unsuspendAt = $suspended->modify("+{$this->suspensionTime} minutes");
		$now = Date::now('UTC');

		if ($unsuspendAt <= $now)
		{
			$this->unsuspend();
		}

		unset($suspended);
		unset($unsuspendAt);
		unset($now);
	}
	
}