<?php namespace Nova\Foundation\Data;

use Status;

trait HasStatus
{
	public function scopeActive($query)
	{
		return $query->where('status', '=', Status::ACTIVE);
	}

	public function scopeInactive($query)
	{
		return $query->where('status', '=', Status::INACTIVE);
	}

	public function scopePending($query)
	{
		return $query->where('status', '=', Status::PENDING);
	}
}
