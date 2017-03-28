<?php namespace Nova\Core\Pages;

use Nova\Foundation\Services\PageCompiler\CompilerEngine;
use Nova\Foundation\Services\PageCompiler\CompilerContract;

class PageContentCompiler implements CompilerContract
{
	protected $identifier = 'content';

	/**
	 * Compile the content.
	 *
	 * @param	string			$value	Content to compile
	 * @param	CompilerEngine	$engine	Instance of the compiler engine
	 * @return	string
	 */
	public function compile($value, CompilerEngine $engine)
	{
		$callback = function ($matches) {
			// Get the values out of the tag
			$args = explode(':', $matches[2]);
			
			// Set the values
			$type = $args[0];
			$key = $args[1];

			// Make sure we're only working with the right type
			if ($type == $this->identifier) {
				if ($matches[1]) {
					return substr($matches[0], 1);
				}

				// Get the content
				$content = app('nova.pageContent')->get($key);

				if ($content) {
					return compile($content);
				}
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
		return "__Additional Page Content__: Insert any piece of additional page content you want into a page by using the `{% content %}` tag. The tag accepts one parameter: the key of the content item you want to get. If you were to store the year your game takes place in as a content item (with a key of _year_ for example), you'd be able to pull it out by using the content tag like this: `{% content:year %}`.";
	}
}
