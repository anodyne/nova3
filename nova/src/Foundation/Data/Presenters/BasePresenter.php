<?php namespace Nova\Foundation\Data\Presenters;

use Laracasts\Presenter\Presenter;

class BasePresenter extends Presenter {

	public function createdAt()
	{
		$dateFormat = app('nova.settings')->get('format_datetime');

		if ($this->entity->created_at)
		{
			return $this->entity->created_at->format($dateFormat);
		}
	}

	public function createdAtRelative()
	{
		return $this->entity->created_at->diffForHumans();
	}

	public function deletedAt()
	{
		$dateFormat = app('nova.settings')->get('format_datetime');

		if ($this->entity->deleted_at)
		{
			return $this->entity->deleted_at->format($dateFormat);
		}
	}

	public function updatedAt()
	{
		$dateFormat = app('nova.settings')->get('format_datetime');

		if ($this->entity->updated_at)
		{
			return $this->entity->updated_at->format($dateFormat);
		}
	}

}
