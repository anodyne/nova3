<?php namespace Nova\Core\Models\Events;

/**
 * Base event handler that sets all the different event methods.
 */

class Base {

	public function saving($model)
	{
		# code...
	}

	public function updating($model)
	{
		# code...
	}

	public function creating($model)
	{
		# code...
	}

	public function created($model)
	{
		# code...
	}

	public function updated($model)
	{
		# code...
	}

	public function saved($model)
	{
		# code...
	}

	public function deleting($model)
	{
		# code...
	}

	public function deleted($model)
	{
		# code...
	}

}