<?php namespace Nova\Core\Forms\Services\Compilers;

use Route;
use Nova\Foundation\Services\PageCompiler\CompilerEngine,
	Nova\Foundation\Services\PageCompiler\CompilerInterface;

class FormCompiler implements CompilerInterface {

	protected $identifier = 'form';

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
			$formKey = $args[1];
			$state = (array_key_exists(2, $args)) ? $args[2] : false;
			$id = (array_key_exists(3, $args)) ? $args[3] : false;

			if ( ! $id and ! $state)
			{
				$state = 'new';
			}

			// Make sure we're only working with the right type
			if ($type == $this->identifier)
			{
				if ($matches[1]) return substr($matches[0], 1);

				// Get the form
				$form = app('FormRepository')->getByKey($formKey, null);

				if ( ! is_numeric($id))
				{
					//"/(@)?{%\s*(.+?)\s*%}(\r?\n)?/s"
					// Get the route parameter
					$paramName = "";

					// Get the current route
					$route = Route::getCurrentRoute();

					// Update the ID
					$id = $route->getParameter($paramName);
				}

				if ($form)
				{
					if ($state == 'view') return $form->present()->renderViewForm($id);

					if ($state == 'edit') return $form->present()->renderEditForm($id);

					if ($state == 'new') return $form->present()->renderNewForm();
				}
				else
				{
					return alert('warning', "No form found with the \"{$formKey}\" form key.");
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
		return "__Forms__: Insert a form into any page by using the `{% form %}` tag. The tag accepts two or three parameters, depending on how you want to use it. The first parameter is the form key of the form you want to display. (You can find the form key on the forms management page.) The second parameter is the specific data ID that you want to use. In most cases, this would be a dynamic property that you would pass to the compiler. The final possible parameter is the state of the form. The options available are: new, edit, and view. `{% form:character:view:8 %}` or `{% form:character:new %}` or `{% form:character:edit:18 %}`";
	}

}
