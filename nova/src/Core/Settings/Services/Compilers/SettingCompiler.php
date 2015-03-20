<?php namespace Nova\Core\Settings\Services\Compilers;

use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\CompilerInterface;

class SettingCompiler implements CompilerInterface {

	/**
	 * Compile the content.
	 *
	 * @param	string			$value	Content to compile
	 * @param	CompilerEngine	$engine	Instance of the compiler engine
	 * @return	string
	 */
	public function compile($value, CompilerEngine $engine)
	{
		$callback = function($matches)
		{
			// Get the values out of the tag
			list($type, $key) = explode(':', $matches[2]);

			// Make sure we're only working with the right type
			if ($type == 'setting')
			{
				if ($matches[1]) return substr($matches[0], 1);

				return app('nova.settings')->{$key};
			}

			return $matches[0];
		};

		return preg_replace_callback($engine->getPattern(), $callback, $value);
	}

	/**
	 * Provide information about this specific compiler.
	 *
	 * @return	string
	 */
	public function help()
	{
		return "__Settings__: Insert settings values into any page by using the `{% setting %}` tag. The tag accepts the setting key as its only parameter (which you can find on the Settings page). If you want to print out the sim name from the settings table for example, you'd enter `{% setting:sim_name %}`. Be careful which settings items you display in publicly viewable content!";
	}

}
