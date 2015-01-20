<?php namespace Nova\Foundation\Services\PageCompiler\Compilers;

use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\CompilerInterface;

class WikiCompiler implements CompilerInterface {

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
			if ($type == 'wiki')
			{
				return ($matches[1]) ? substr($matches[0], 1) : "(({$key}))";
			}

			return $matches[0];
		};

		return preg_replace_callback($engine->getPattern(), $callback, $value);
	}

}