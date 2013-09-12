<?php
/**
 * Helpers used throughout Nova.
 *
 * @package		Nova
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

/**
 * Translate the language key into the appropriate language.
 *
 * @param	string	I18n key to translate
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
 * Generate a partial.
 *
 * @param	string	The view name
 * @param	mixed	The data to pass to the partial
 * @return	string
 */
if ( ! function_exists('partial'))
{
	function partial($view, $data = false)
	{
		$viewObj = View::make(Location::partial($view));

		// Make sure we have data before attaching it
		if ($data !== false)
		{
			return $viewObj->with($data);
		}

		return $viewObj;
	}
}

/**
 * Generate a modal.
 *
 * @param	array	The data to pass to the modal
 * @return	string
 */
if ( ! function_exists('modal'))
{
	function modal(array $data = [])
	{
		// Set the variables
		$id		= (array_key_exists('id', $data)) ? $data['id'] : false;
		$header	= (array_key_exists('header', $data)) ? $data['header'] : false;
		$body	= (array_key_exists('body', $data)) ? $data['body'] : false;
		$footer	= (array_key_exists('footer', $data)) ? $data['footer'] : false;

		return View::make(Location::partial('common/modal'))
			->with('modalId', $id)
			->with('modalHeader', $header)
			->with('modalBody', $body)
			->with('modalFooter', $footer);
	}
}