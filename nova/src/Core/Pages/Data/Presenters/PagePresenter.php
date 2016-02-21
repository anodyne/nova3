<?php namespace Nova\Core\Pages\Data\Presenters;

use Laracasts\Presenter\Presenter;

class PagePresenter extends Presenter {

	public function access()
	{
		// Find the permission
		$permission = app('PermissionRepository')->getFirstBy('name', $this->entity->access);

		if ($permission) return $permission->present()->displayName;
	}

	public function message()
	{
		if ($this->entity->message())
			return app('nova.markdown')->parse($this->entity->message()->present()->value);
	}

	public function messageRaw()
	{
		if ($this->entity->message())
			return $this->entity->message()->value;
	}

	public function header()
	{
		if ($this->entity->header())
			return $this->entity->header()->present()->value;
	}

	public function title()
	{
		if ($this->entity->title())
			return $this->entity->title()->present()->value;
	}

	public function verb()
	{
		return $this->entity->verb;
	}

	public function verbAsLabel()
	{
		$verb = $this->verb();

		switch ($verb)
		{
			case 'GET':
				$level = 'success';
			break;

			case 'PUT':
				$level = 'info';
			break;

			case 'POST':
				$level = 'warning';
			break;

			case 'DELETE':
				$level = 'danger';
			break;
		}

		return label($level, $verb);
	}

	public function defaultResource()
	{
		return $this->entity->default_resource;
	}

}
