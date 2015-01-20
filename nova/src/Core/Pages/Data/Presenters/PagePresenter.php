<?php namespace Nova\Core\Pages\Data\Presenters;

use Laracasts\Presenter\Presenter;

class PagePresenter extends Presenter {

	public function content()
	{
		return app('nova.pages.compiler')->compile($this->entity->content);
	}

	public function header()
	{
		return $this->entity->header;
	}

	public function title()
	{
		return $this->entity->title;
	}

}