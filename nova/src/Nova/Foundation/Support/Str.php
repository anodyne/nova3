<?php namespace Nova\Foundation\Support;

use Illuminate\Support\Str as lStr;

class Str extends lStr {

	/**
	 * Get the length of a string.
	 *
	 * @param  string  $value
	 * @return int
	 */
	public static function length($value)
	{
		$mbString = (bool) function_exists('mb_get_info');

		return ($mbString) ? mb_strlen($value, 'utf-8') : strlen($value);
	}

	/**
	 * Limit the number of words in a string.
	 *
	 * @param  string  $value
	 * @param  int     $words
	 * @param  string  $end
	 * @return string
	 */
	public static function words($value, $words = 100, $end = '...')
	{
		if (trim($value) == '') return '';

		preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

		if (static::length($value) == static::length($matches[0]))
		{
			$end = '';
		}

		return rtrim($matches[0]).$end;
	}

	/**
	 * Takes the namespace off the given class name.
	 *
	 * @author	FuelPHP
	 * @param	string	The class name
	 * @return	string
	 */
	public static function denamespace($className)
	{
		$className = trim($className, '\\');

		if ($lastSeparator = strrpos($className, '\\'))
		{
			$className = substr($className, $lastSeparator + 1);
		}
		
		return $className;
	}

	/**
	 * Returns the namespace of the given class name.
	 *
	 * @author	FuelPHP
	 * @param	string	The class name
	 * @return	string
	 */
	public static function getNamespace($className)
	{
		$className = trim($className, '\\');
		
		if ($lastSeparator = strrpos($className, '\\'))
		{
			return substr($className, 0, $lastSeparator + 1);
		}
		
		return '';
	}
}
