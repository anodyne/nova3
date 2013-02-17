<?php
/**
 * Part of the Sentry package for Nova.
 *
 * @package		Nova
 * @subpackage	Sentry
 * @category	Class
 * @author		Cartalyst LLC
 * @author		Anodyne Productions
 * @license		MIT License
 * @copyright	2011 Cartalyst LLC
 */

namespace Nova\Sentry;

use Lang;
use Date;
use UserModel;
use SettingsModel;
use UserSuspendModel;

class SentryAttemptsException extends \Exception {}
class SentryUserSuspendedException extends SentryAttemptsException {}

class Attempts {

	/**
	 * @var  array  Stores suspension/limit config data
	 */
	protected static $limit = array();

	/**
	 * @var  string  Login id
	 */
	protected $loginId = null;

	/**
	 * @var  string  IP address
	 */
	protected $ipAddress = null;

	/**
	 * @var  int  Number of login attempts
	 */
	protected $attempts = null;

	/**
	 * Attempts Constructor
	 *
	 * @param	string	User login
	 * @param	string	IP address
	 * @return	Sentry\Attempts
	 * @throws	SentryAuthConfigException
	 * @throws	SentryAttemptsException
	 */
	public function __construct($loginId = null, $ipAddress = null)
	{
		static::$limit = array(
			'enabled'	=> true,
			'attempts'	=> (int) SettingsModel::getItems('login_attempts'),
			'time'		=> (int) SettingsModel::getItems('login_lockout_time'),
		);
		$this->loginId = $loginId;
		$this->ipAddress = $ipAddress;

		// Limit checks
		if (static::$limit['enabled'] === true)
		{
			if ( ! is_int(static::$limit['attempts']) or static::$limit['attempts'] <= 0)
			{
				throw new SentryAuthConfigException(Lang::get('sentry.invalid_limit_attempts'));
			}

			if ( ! is_int(static::$limit['time']) or static::$limit['time'] <= 0)
			{
				throw new SentryAuthConfigException(Lang::get('sentry.invalid_limit_time'));
			}
		}

		$query = UserSuspendModel::query();

		if ($this->loginId)
		{
			$query = $query->where('login_id', $this->loginId);
		}

		if ($this->ipAddress)
		{
			$query = $query->where('ip', $this->ipAddress);
		}

		$result = $query->get();

		foreach ($result as &$row)
		{
			// Check if last attempt was more than 15 min ago - if so reset counter
			if ($row['last_attempt_at'])
			{
				// Create a last attempt date object
				$la = Date::createFromFormat('Y-m-d H:i:s', $row['last_attempt_at']);

				if ($la->diffInSeconds($la->copy()->addMinutes(static::$limit['time'])) <= 0)
				{
					$this->clear($row['login_id'], $row['ip']);
					$row['attempts'] = 0;
				}
			}

			// Check unsuspended time and clear if time is > than it
			if ($row['unsuspend_at'])
			{
				// Create an unsuspend at date object
				$ua = Date::createFromFormat('Y-m-d H:i:s', $row['unsuspend_at']);

				if ($ua->diffInSeconds(null) <= 0)
				{
					$this->clear($row['login_id'], $row['ip']);
					$row['attempts'] = 0;
				}
			}
		}

		if (count($result) > 1)
		{
			$this->attempts = $result;
		}
		elseif ($result)
		{
			$row = reset($result);

			$this->attempts = (int) $row->attempts;
		}
		else
		{
			$this->attempts = 0;
		}
	}

	/**
	 * Check Number of Login Attempts
	 *
	 * @return  int
	 */
	public function get()
	{
		return $this->attempts;
	}

	/**
	 * Gets attempt limit number
	 *
	 * @return  int
	 */
	 public function getLimit()
	 {
	 	return static::$limit['attempts'];
	 }

	/**
	 * Add Login Attempt
	 *
	 * @param string
	 * @param int
	 */
	public function add()
	{
		// Make sure a login id and ip address are set
		if (empty($this->loginId) or empty($this->ipAddress))
		{
			throw new SentryAttemptsException(Lang::get('sentry.login_ip_required'));
		}

		// this shouldn't happen, but put it just to make sure
		if (is_array($this->attempts))
		{
			throw new SentryAttemptsException(Lang::get('sentry.single_user_required'));
		}

		if ($this->attempts)
		{
			// Find the record
			$record = UserSuspendModel::getItem(array(
				'login_id' 	=> $this->loginId,
				'ip' 		=> $this->ipAddress
			));
			
			// Update the record
			$result = UserSuspendModel::updateItem($record->id, array(
				'attempts' 			=> ++$this->attempts,
				'last_attempt_at' 	=> Date::now()->toDateTimeString(),
			));
		}
		else
		{
			$result = UserSuspendModel::createItem(array(
				'login_id' 			=> $this->loginId,
				'ip' 				=> $this->ipAddress,
				'attempts' 			=> ++$this->attempts,
				'last_attempt_at' 	=> Date::now()->toDateTimeString(),
			));
		}
	}

	/**
	 * Clear Login Attempts
	 *
	 * @param string
	 * @param string
	 */
	public function clear()
	{
		if ($this->loginId)
		{
			$query = UserSuspendModel::clearItem(array('login_id' => $this->loginId));
		}

		if ($this->ipAddress)
		{
			$query = UserSuspendModel::clearItem(array('ip' => $this->ipAddress));
		}

		$this->attempts = 0;
	}

	/**
	 * Suspend
	 *
	 * @param string
	 * @param int
	 */
	public function suspend()
	{
		if (empty($this->loginId) or empty($this->ipAddress))
		{
			throw new SentryUserSuspendedException(Lang::get('sentry.login_ip_required'));
		}
		
		// Find the record
		$record = \Model_User_Suspend::query()
			->where('login_id', $this->loginId)
			->where('ip', $this->ipAddress)
			->where('unsuspend_at', null)
			->or_where('unsuspend_at', 0)
			->get();

		// Get the current time
		$now = Date::now();
		
		// Update the record
		$result = UserSuspendModel::updateItem($record->id, array(
			'suspended_at' => $now->toDateTimeString(),
			'unsuspend_at' => $now->copy()->addMinutes(static::$limit['time'])->toDateTimeString()
		));

		// Get the user
		$u = UserModel::getItem($login_column_value, 'email');

		// create an event
		\SystemEvent::add(false, '[[event.login.suspend|{{'.$u->name.'}}]]');

		return \Login\Controller_Login::SUSPEND_START;
	}
}
