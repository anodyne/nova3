<?php namespace Nova\Foundation\Database\Eloquent;

use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Collection extends EloquentCollection {

	/**
	 * Convert a collection to a simple array.
	 *
	 * @param	string	The column to use for the key
	 * @param	string	The column to use for the value
	 * @return	array
	 */
	public function toSimpleArray($key = 'id', $value = 'name')
	{
		foreach ($this->items as $item)
		{
			$final[$item->{$key}] = $item->{$value};
		}

		return $final;
	}

}