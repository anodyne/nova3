<?php namespace Nova\Core\Pages\Data\Presenters;

use BasePresenter;

class PageContentPresenter extends BasePresenter
{
	public function value()
	{
		if ($this->entity->value) {
			return app('nova.page.compiler')->compile($this->entity->value);
		}
	}
}
