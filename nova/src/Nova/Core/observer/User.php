<?php

namespace Nova\Core\Observer;

use Nova\Foundation\Database\Observer;
use Nova\Foundation\Database\Eloquent\Model;

class User extends Observer
{
	public function beforeInsert(Model $model)
	{
		return "Fired beforeInsert";
	}

	public function afterInsert(Model $model)
	{
		return "Fired afterInsert";
	}

	public function beforeUpdate(Model $model)
	{
		return "Fired beforeUpdate";
	}

	public function afterUpdate(Model $model)
	{
		return "Fired afterUpdate";
	}

	public function beforeDelete(Model $model)
	{
		return "Fired beforeDelete";
	}
}
