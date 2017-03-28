<?php namespace Nova\Core\Forms\Services\FieldTypes;

class FieldTypeManager
{
	protected $types;
	protected $requiredInfoKeys = ['name', 'value', 'hasValues', 'values', 'baseHTML'];

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
		if ($this->types->has($alias)) {
			return $this->types->get($alias);
		}

		throw new FieldTypeException("There are no field types registered with an alias of {$alias}.");
	}

	public function registerFieldType($alias, $concrete)
	{
		if ($this->types->has($alias)) {
			throw new FieldTypeException("A field type is already registered with an alias of {$alias}. Please select another field type alias.");
		}

		// Get the differences between the arrays
		$diffArr = array_diff($this->requiredInfoKeys, array_keys($concrete->info()));

		if (count($diffArr) > 0) {
			throw new FieldTypeException("The info array does not contain all of the required elements.");
		}

		// Put the field type into the collection
		$this->types->put($alias, $concrete);

		return $this;
	}
}
