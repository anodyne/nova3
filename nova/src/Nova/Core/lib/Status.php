<?php namespace Nova\Core\Lib;

class Status {

	const PENDING		= 1;
	const INACTIVE		= 2;
	const ACTIVE		= 3;
	const REMOVED		= 4;
	const IN_PROGRESS	= 5;
	const APPROVED		= 6;
	const REJECTED		= 7;

	/**
	 * Translate a status into a string.
	 *
	 * @todo	Switch over to the language helper
	 * @param	int		Status to translate
	 * @return	int
	 */
	public static function toString($status)
	{
		switch ($status)
		{
			case self::PENDING:
				$final = 'pending';
			break;

			case self::INACTIVE:
				$final = 'inactive';
			break;

			case self::ACTIVE:
				$final = 'active';
			break;

			case self::IN_PROGRESS:
				$final = 'in progress';
			break;

			case self::APPROVED:
				$final = 'approved';
			break;

			case self::REJECTED:
				$final = 'rejected';
			break;

			default:
				$final = 'status not found';
			break;
		}

		return $final;
	}

	/**
	 * Translate a string into a status.
	 *
	 * @param	string	Text to translate from
	 * @return	int
	 */
	public static function toInt($str)
	{
		switch ($str)
		{
			case 'active':
			case 'current':
				$final = self::ACTIVE;
			break;

			case 'removed':
			case 'deleted':
			case 'archived':
				$final = self::REMOVED;
			break;

			case 'old':
			case 'inactive':
			case 'previous':
				$final = self::INACTIVE;
			break;

			case 'pending':
			case 'applied':
			case 'waiting':
				$final = self::PENDING;
			break;

			case 'work in progress':
			case 'wip':
			case 'saved':
			case 'in progress':
				$final = self::IN_PROGRESS;
			break;

			case 'approve':
			case 'approved':
				$final = self::APPROVED;
			break;

			case 'reject':
			case 'rejected':
				$final = self::REJECTED;
			break;
		}

		return $final;
	}

}