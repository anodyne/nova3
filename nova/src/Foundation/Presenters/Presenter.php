<?php

namespace Nova\Foundation\Presenters;

use Laracasts\Presenter\Presenter as BasePresenter;

abstract class Presenter extends BasePresenter
{
	public function presentCreatedAt()
	{
		return $this->created_at->format('Y-m-d g:i:s a');
	}

	public function presentCreatedAtForHumans()
	{
		return $this->created_at->diffForHumans();
	}

	public function presentUpdatedAt()
	{
		return $this->updated_at->format('Y-m-d g:i:s a');
	}

	public function presentUpdatedAtForHumans()
	{
		return $this->updated_at->diffForHumans();
	}
}
