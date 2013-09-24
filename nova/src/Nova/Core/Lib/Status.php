<?php namespace Nova\Core\Lib;

use Exception;

class Status {

	const PENDING		= 1;
	const INACTIVE		= 2;
	const ACTIVE		= 3;
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
				$final = lang('pending');
			break;

			case static::INACTIVE:
				$final = lang('inactive');
			break;

			case static::ACTIVE:
				$final = lang('active');
			break;

			case static::IN_PROGRESS:
				$final = lang('in_progress');
			break;

			case static::APPROVED:
				$final = lang('approved');
			break;

			case static::REJECTED:
				$final = lang('rejected');
			break;

			case static::ASSIGNED:
				$final = lang('assigned');
			break;

			case static::UNASSIGNED:
				$final = lang('unassigned');
			break;

			default:
				$final = false;
				throw new Exception("Unexpected input. {$status} is not a valid status code.");
			break;
		}

		return $final;
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
				$final = static::ACTIVE;
			break;

			case 'removed':
			case 'deleted':
			case 'archived':
				$final = static::REMOVED;
			break;

			case 'old':
			case 'inactive':
			case 'previous':
				$final = static::INACTIVE;
			break;

			case 'pending':
			case 'applied':
			case 'waiting':
				$final = static::PENDING;
			break;

			case 'work in progress':
			case 'wip':
			case 'saved':
			case 'in progress':
				$final = static::IN_PROGRESS;
			break;

			case 'approve':
			case 'approved':
				$final = static::APPROVED;
			break;

			case 'reject':
			case 'rejected':
				$final = static::REJECTED;
			break;

			case 'assigned':
				$final = static::ASSIGNED;
			break;

			case 'unassigned':
				$final = static::UNASSIGNED;
			break;

			default:
				$final = false;
				throw new Exception("Unexpected input. {$status} is not a valid status string.");
			break;
		}

		return $final;
	}

}