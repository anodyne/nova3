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
	 * @param	int		Status to translate
	 * @return	int
	 */
	public static function toString($status)
	{
		switch ($status)
		{
			case self::PENDING:
				$final = lang('pending');
			break;

			case self::INACTIVE:
				$final = lang('inactive');
			break;

			case self::ACTIVE:
				$final = lang('active');
			break;

			case self::IN_PROGRESS:
				$final = lang('in_progress');
			break;

			case self::APPROVED:
				$final = lang('approved');
			break;

			case self::REJECTED:
				$final = lang('rejected');
			break;

			default:
				$final = lang('error.notFound', lang('status'));
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