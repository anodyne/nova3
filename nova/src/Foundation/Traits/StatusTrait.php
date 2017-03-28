<?php namespace Nova\Foundation\Traits;

use Status;

trait StatusTrait
{
	public function scopeActive($query)
	{
		$query->where('status', Status::ACTIVE);
	}

	public function scopeApproved($query)
	{
		$query->where('status', Status::APPROVED);
	}

	public function scopeAssigned($query)
	{
		$query->where('status', Status::ASSIGNED);
	}

	public function scopeInactive($query)
	{
		$query->where('status', Status::INACTIVE);
	}

	public function scopeInProgress($query)
	{
		$query->where('status', Status::IN_PROGRESS);
	}

	public function scopePending($query)
	{
		$query->where('status', Status::PENDING);
	}

	public function scopeRejected($query)
	{
		$query->where('status', Status::REJECTED);
	}

	public function scopeRemoved($query)
	{
		$query->where('status', Status::REMOVED);
	}

	public function scopeStatus($query, $status, $operator = null)
	{
		if (is_array($status)) {
			$query->whereIn('status', $status);
		} else {
			if ($operator) {
				$query->where('status', $operator, $status);
			} else {
				$query->where('status', $status);
			}
		}
	}
	
	public function scopeUnassigned($query)
	{
		$query->where('status', Status::UNASSIGNED);
	}
}
