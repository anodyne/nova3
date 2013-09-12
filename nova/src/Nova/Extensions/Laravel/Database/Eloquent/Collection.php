<?php namespace Nova\Extensions\Laravel\Database\Eloquent;

use stdClass;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Collection extends EloquentCollection {

	/**
	 * Convert a collection to a simple array.
	 *
	 * @param	string	$key	The column to use for the key
	 * @param	string	$value	The column to use for the value
	 * @return	array
	 */
	public function toSimpleArray($key = 'id', $value = 'name')
	{
		$final = [];

		foreach ($this->items as $item)
		{
			if (empty($key))
				$final[] = $item->{$value};
			else
				$final[$item->{$key}] = $item->{$value};
		}

		return $final;
	}

	public function toMultiArray($key)
	{
		$final = [];

		foreach ($this->items as $item)
		{
			$final[$item->{$key}][] = $item;
		}

		return $final;
	}

	/**
	 * Convert a collection to a simple JSON object.
	 *
	 * @param	string	The column to use for the key
	 * @param	string	The column to use for the value
	 * @return	array
	 */
	public function toSimpleJson($key = 'id', $value = 'name')
	{
		return json_encode($this->toSimpleArray($key, $value));
	}

	/**
	 * Convert a collection to a simple object.
	 *
	 * @param	string	The column to use for the key
	 * @param	string	The column to use for the value
	 * @return	object
	 */
	public function toSimpleObject($key = 'id', $value = 'name')
	{
		$final = new stdClass;

		foreach ($this->items as $item)
		{
			$final->{$item->{$key}} = $item->{$value};
		}

		return $final;
	}

}