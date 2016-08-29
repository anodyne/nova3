<?php namespace Nova\Core\Users\Data\Presenters;

use Status, BasePresenter;

class UserPresenter extends BasePresenter {

	public function firstName()
	{
		if ($this->entity->nickname)
		{
			return $this->entity->nickname;
		}

		return explode(' ', $this->entity->name)[0];
	}

	public function lastPasswordReset()
	{
		$dateFormat = app('nova.settings')->get('format_datetime');

		if ($this->entity->last_password_reset)
		{
			return $this->entity->last_password_reset->format($dateFormat);
		}
	}

	public function lastPasswordResetRelative()
	{
		if ($this->entity->last_password_reset)
		{
			return $this->entity->last_password_reset->diffForHumans();
		}
	}

	public function name()
	{
		if ($this->entity->nickname)
		{
			return $this->entity->nickname;
		}

		if ($this->entity->name)
		{
			return $this->entity->name;
		}

		return $this->entity->email;
	}

	public function realName()
	{
		return $this->entity->name;
	}

	public function statusAsLabel()
	{
		$status = $this->entity->status;

		switch ($status)
		{
			case Status::ACTIVE:
				$level = 'success';
			break;

			case Status::INACTIVE:
				$level = 'default';
			break;

			case Status::PENDING:
				$level = 'warning';
			break;
		}

		return label($level, ucwords(Status::toString($status)));
	}

}
