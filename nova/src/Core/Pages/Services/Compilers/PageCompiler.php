<?php namespace Nova\Core\Pages\Services\Compilers;

use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\CompilerInterface;

class PageCompiler implements CompilerInterface {

	/**
	 * Compile the content.
	 *
	 * @param	string			$value	Content to compile
	 * @param	CompilerEngine	$engine	Instance of the compiler engine
	 * @return	string
	 */
	public function compile($value, CompilerEngine $engine)
	{
		$callback = function ($matches)
		{
			// Get the values out of the tag
			$args = explode(':', $matches[2]);
			
			// Set the values
			$type = $args[0];
			$key = $args[1];
			$title = (array_key_exists(2, $args)) ? $args[2] : false;

			// Make sure we're only working with the right type
			if ($type == 'page')
			{
				if ($matches[1])
				{
					return substr($matches[0], 1);
				}

				// Get the page
				$page = app('PageRepository')->getByRouteKey($key, null);

				if ($page)
				{
					$title = ($title) ?: $page->present()->name;

					return app('html')->linkRoute($key, $title);
				}
				else
				{
					$title = ($title) ?: 'Page Not Found';

					return app('html')->link(false, $title, [
						'class' => 'broken-link js-tooltip-top',
						'title' => "Page not found"
					]);
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
		return "__Pages__: Insert a link into any page by using the `{% page %}` tag. The tag accepts two or three parameters, depending on how you want to use it. You can set the title used for the link by setting the third parameter. For example, if you want to link to the home page and have the link say \"home\" instead of the name listed in the database, enter `{% page:home:home %}`. If you don't enter the third parameter, like `{% page:game.rules %}`, the name of the page will be pulled from the database and used as the link title.";
	}

}
