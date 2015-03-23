<?php namespace Nova\Core\Pages\Data\Presenters;

use Laracasts\Presenter\Presenter;

class PageContentPresenter extends Presenter {

	public function value()
	{
		if ($this->entity->value)
			return app('nova.page.compiler')->compile($this->entity->value);
	}

}
