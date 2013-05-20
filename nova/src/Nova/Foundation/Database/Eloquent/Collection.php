<?php namespace Nova\Foundation\Database\Eloquent;

use stdClass;
use Nova\Core\Contracts\CollectionInterface;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Collection extends EloquentCollection implements CollectionInterface {

	/**
	 * Convert a collection to a simple array.
	 *
	 * @param	string	The column to use for the key
	 * @param	string	The column to use for the value
	 * @return	array
	 */
	public function toSimpleArray($key = 'id', $value = 'name')
	{
		$final = array();

		foreach ($this->items as $item)
		{
			$final[$item->{$key}] = $item->{$value};
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

	/*
	|--------------------------------------------------------------------------
	| CollectionInterface Implementation
	|--------------------------------------------------------------------------
	*/

	protected $collectionName;

	/**
	 * Return ETag based on collection of items.
	 *
	 * @return	string
	 */
	public function getEtags($regen = false)
	{
		$etag = '';

		foreach ($this as $resource)
		{
			$etag.= $resource->getEtag($regen);
		}

		return md5($etag);
	}

	/**
	 * Set the name of the collection for API resource output.
	 *
	 * @param	string	Name of the collection
	 * @return	Collection
	 */
	public function setCollectionName($name)
	{
		$this->collectionName = $name;

		return $this;
	}

	/**
	 * Retrieve the collection name.
	 *
	 * @return	string
	 */
	public function getCollectionName()
	{
		return $this->collectionName;
	}

}