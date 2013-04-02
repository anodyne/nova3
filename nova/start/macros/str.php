<?php

/**
 * Takes the namespace off the given class name.
 *
 * @author	FuelPHP
 * @param	string	The class name
 * @return	string
 */
Str::macro('denamespace', function($className)
{
	$className = trim($className, '\\');

	if ($lastSeparator = strrpos($className, '\\'))
	{
		$className = substr($className, $lastSeparator + 1);
	}
	
	return $className;
});

/**
 * Returns the namespace of the given class name.
 *
 * @author	FuelPHP
 * @param	string	The class name
 * @return	string
 */
Str::macro('getNamespace', function($className)
{
	$className = trim($className, '\\');
	
	if ($lastSeparator = strrpos($className, '\\'))
	{
		return substr($className, 0, $lastSeparator + 1);
	}
	
	return '';
});

/**
 * Limit the number of words in a string.
 *
 * @param	string	The string to limit
 * @param	int		Number of words to limit to
 * @param	string	What to use at the end of the limited string
 * @return	string
 */
Str::macro('words', function($value, $words = 100, $end = '...')
{
	if (trim($value) == '') return '';

	preg_match('/^\s*+(?:\S++\s*+){1,'.$words.'}/u', $value, $matches);

	if (Str::length($value) == Str::length($matches[0]))
	{
		$end = '';
	}

	return rtrim($matches[0]).$end;
});

/**
 * Get the length of a string.
 *
 * @param	string	The string
 * @return	int
 */
Str::macro('length', function($value)
{
	$mbString = (bool) function_exists('mb_get_info');

	return ($mbString) ? mb_strlen($value, 'utf-8') : strlen($value);
});