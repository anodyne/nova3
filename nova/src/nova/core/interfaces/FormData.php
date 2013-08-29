<?php namespace nova\core\interfaces;

interface FormData {

	/**
	 * Create field data values for the different entries
	 * when create a new field.
	 *
	 * @param	array	Data to put into the database
	 * @return	void
	 */
	public static function createFieldData(array $data);

}