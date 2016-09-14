<?php namespace Nova\Foundation\Services;

use Exception;

class StatusService {

	const PENDING		= 1;
	const ACTIVE		= 2;
	const INACTIVE		= 3;
	const REMOVED		= 4;
	const IN_PROGRESS	= 5;
	const APPROVED		= 6;
	const REJECTED		= 7;
	const ASSIGNED		= 8;
	const UNASSIGNED	= 9;

	/**
	 * Translate a status into a string.
	 *
	 * @param	int		$status		Status to translate
	 * @return	string
	 */
	public static function toString($status)
	{
		switch ($status)
		{
			case static::PENDING:
				return "pending";
			break;

			case static::INACTIVE:
				return "inactive";
			break;

			case static::ACTIVE:
				return "active";
			break;

			case static::IN_PROGRESS:
				return "in progress";
			break;

			case static::APPROVED:
				return "approved";
			break;

			case static::REJECTED:
				return "rejected";
			break;

			case static::ASSIGNED:
				return "assigned";
			break;

			case static::UNASSIGNED:
				return "unassigned";
			break;
		}

		throw new Exception("Unexpected input. {$status} is not a valid status code.");
	}

	/**
	 * Translate a string into a status.
	 *
	 * @param	string	$status		Text to translate
	 * @return	int
	 */
	public static function toInt($status)
	{
		switch ($status)
		{
			case 'active':
			case 'current':
				return static::ACTIVE;
			break;

			case 'removed':
			case 'deleted':
			case 'archived':
				return static::REMOVED;
			break;

			case 'old':
			case 'inactive':
			case 'previous':
				return static::INACTIVE;
			break;

			case 'pending':
			case 'applied':
			case 'waiting':
				return static::PENDING;
			break;

			case 'work in progress':
			case 'wip':
			case 'saved':
			case 'in progress':
				return static::IN_PROGRESS;
			break;

			case 'approve':
			case 'approved':
				return static::APPROVED;
			break;

			case 'reject':
			case 'rejected':
				return static::REJECTED;
			break;

			case 'assigned':
				return static::ASSIGNED;
			break;

			case 'unassigned':
				return static::UNASSIGNED;
			break;
		}

		throw new Exception("Unexpected input. {$status} is not a valid status string.");
	}

}
