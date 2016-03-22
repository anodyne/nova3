<?php namespace Nova\Core\Forms\Services\FieldTypes;

class FieldTypeManager {

	protected $types;

	public function __construct()
	{
		$this->types = collect();
	}

	public function getAllFieldTypes()
	{
		return $this->types;
	}

	public function getFieldType($alias)
	{
		if ($this->types->has($alias))
		{
			return $this->types->get($alias);
		}

		throw new FieldTypeException("There are no field types registered with an alias of {$alias}.");
	}

	public function registerFieldType($alias, $concrete)
	{
		if ($this->types->has($alias))
		{
			throw new FieldTypeException("A field type is already registered with an alias of {$alias}. Please select another field type alias.");
		}

		$this->types->put($alias, $concrete);

		return $this;
	}

}
