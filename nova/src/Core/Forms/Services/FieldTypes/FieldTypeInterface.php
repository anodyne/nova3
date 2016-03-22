<?php namespace Nova\Core\Forms\Services\FieldTypes;

interface FieldTypeInterface {

	public function info();
	public function render($state, $name, $values, $data, array $attributes);

}
