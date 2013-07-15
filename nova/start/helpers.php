<?php
/**
 * Helpers used throughout Nova.
 *
 * @package		Nova
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
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

		// Set the key
		$key = $args[0];

		// Should we capitalize?
		$capitalize = (ctype_upper($key{0}));

		// Make sure the first letter is lower-cased
		$key = lcfirst($key);

		// The first will always be the key to translate
		$key = ( ! Str::contains($key, '.')) ? 'base.'.$key : $key;

		// Set up an empty array of arguments
		$argsArray = array();

		// Remove the first item from the arguments
		unset($args[0]);

		// Re-index the array
		$argsArray = array_values($args);

		$output = Lang::get($key, $argsArray);

		return ($capitalize) ? ucfirst($output) : $output;
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
			// Should we be capitalizing?
			$capitalize = (ctype_upper($value{0}));

			// Make sure we're lower-cased
			$value = Str::lower($value);

			// Make sure the value is right
			$value = ( ! Str::contains($value, '.')) ? 'base.'.$value : $value;

			// Run the content through the translator
			$retval[$key] = ($capitalize) ? ucfirst(Lang::get($value)) : Lang::get($value);
		}

		return implode(' ', $retval);
	}
}

/**
 * Generate a partial based on the parameters.
 *
 * @param	string	The view name
 * @param	string	The section (main or admin)
 * @param	mixed	The data to pass to the partial
 * @return	string
 */
function partial($view, $data)
{
	return View::make(Location::partial($view))->with($data);
}

/**
 * Parse route conditions.
 *
 * @param	string	The route conditions
 * @return	array
 */
if ( ! function_exists('parseRouteConditions'))
{
	function parseRouteConditions($conditions)
	{
		// Create an empty array for storing conditions
		$finalConditions = [];
		
		// We have a pipe, so we need to break things apart twice
		if (Str::contains($conditions, '|'))
		{
			// Create an array of conditions
			$conditionsArr = explode('|', $conditions);

			// Loop through the conditions array
			foreach ($conditionsArr as $c)
			{
				// Break the conditions up
				list($name, $pattern) = explode('.', $c);

				// Add the conditions to the final array
				$finalConditions[] = [$name => $condition];
			}
		}
		else
		{
			// Break the conditions up
			list($name, $pattern) = explode('.', $conditions);

			// Set the final conditions
			$finalConditions[$name] = $pattern;
		}

		return $finalConditions;
	}
}