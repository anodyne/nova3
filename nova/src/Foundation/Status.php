<?php namespace Nova\Foundation;

class Status
{
	const PENDING		= 1;
	const ACTIVE		= 2;
	const INACTIVE		= 3;
	const REMOVED		= 4;
	const IN_PROGRESS	= 5;
	const APPROVED		= 6;
	const REJECTED		= 7;
	const ASSIGNED		= 8;
	const UNASSIGNED	= 9;
	const COMPLETED		= 10;

	public static function all()
	{
		return [
			'pending' => static::PENDING,
			'active' => static::ACTIVE,
			'inactive' => static::INACTIVE,
			'removed' => static::REMOVED,
			'in_progress' => static::IN_PROGRESS,
			'approved' => static::APPROVED,
			'rejected' => static::REJECTED,
			'assigned' => static::ASSIGNED,
			'unassigned' => static::UNASSIGNED,
			'completed' => static::COMPLETED,
		];
	}

	public static function toInt($value)
	{
		switch ($value) {
			case 'active':
				return static::ACTIVE;
				break;

			case 'completed':
				return static::COMPLETED;
				break;

			case 'current':
				return static::ACTIVE;
				break;

			case 'inactive':
				return static::INACTIVE;
				break;

			case 'pending':
			case 'upcoming':
				return static::PENDING;
				break;
		}
	}

	public static function toString($value)
	{
		//
	}
}
