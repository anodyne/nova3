<?php namespace Nova\Core\Models\Events;

/**
 * Base event handler that sets all the different event methods.
 */

class Base {

	public function beforeSave($model)
	{
		# code...
	}

	public function beforeUpdate($model)
	{
		# code...
	}

	public function beforeCreate($model)
	{
		# code...
	}

	public function afterCreate($model)
	{
		# code...
	}

	public function afterUpdate($model)
	{
		# code...
	}

	public function afterSave($model)
	{
		# code...
	}

	public function beforeDelete($model)
	{
		# code...
	}

	public function afterDelete($model)
	{
		# code...
	}

}