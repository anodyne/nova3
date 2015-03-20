<?php namespace Nova\Foundation\Services\PageCompiler\Compilers;

use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\CompilerInterface;

class IconCompiler implements CompilerInterface {

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

			// Get the values out of the tag
			$args = explode(':', $matches[2]);
			
			// Set the values
			$type = $args[0];
			$icon = $args[1];
			$size = (array_key_exists(2, $args)) ? $args[2] : 'sm';
			$additional = (array_key_exists(3, $args)) ? $args[2] : false;

			// Make sure we're only working with the right type
			if ($type == 'icon')
			{
				if ($matches[1]) return substr($matches[0], 1);

				return icon(config("icons.{$icon}"), $size, $additional);
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
		return "__Icons__: Insert an icon into any page by using the `{% icon %}` tag. The tag accepts three parameters. The first parameter is always the icon you want to use. The second paramter is the size of the icon (sm, md, lg). The third parameter are any additional classes you want applied to the icon. To insert a large edit icon into a page, you would enter: `{% icon:edit:lg %}`.";
	}

}
