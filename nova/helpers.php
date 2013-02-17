<?php
/**
 * Helpers used throughout Nova.
 *
 * @package		Nova
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

/**
 * @param	string	The i18n key to translate
 * @param	string	Any values that need to be passed to the key as well
 * @return	string
 * @throws	Exception
 */
if ( ! function_exists('lang'))
{
	function lang()
	{
		// Get all the arguments passed
		$args = func_get_args();

		// We have to have arguments
		if (count($args) == 0)
		{
			throw new Exception('lang() must have at least 1 parameter defined for the language key');
		}

		// The first will always be the key to translate
		$key = $args[0];

		// Set up an empty array of arguments
		$argsArray = array();

		// Remove the first item from the arguments
		unset($args[0]);

		// Re-index the array
		$argsArray = array_values($args);

		return Lang::get($key, $argsArray);
	}
}

/**
 * Takes a string with spaces and translates each of the pieces.
 *
 * @param	string	The string
 * @return	string
 */
if ( ! function_exists('langConcat'))
{
	function langConcat($str)
	{
		// Break the string into an array
		$pieces = explode(' ', $str);

		// Loop through the array
		foreach ($pieces as $key => $value)
		{
			// Run the content through the translator
			$retval[$key] = Lang::get($value);
		}

		return implode(' ', $retval);
	}
}