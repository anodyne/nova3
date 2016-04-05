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
				if ($matches[1])
				{
					return substr($matches[0], 1);
				}

				// Get the form
				$form = app('FormRepository')->getByKey($formKey, []);

				if ( ! is_numeric($id))
				{
					// Get the route parameter
					preg_match("/(?<=\{)(.*?)(?=\})/", $id, $paramMatches);

					if (count($paramMatches) > 0)
					{
						$id = Route::getCurrentRoute()->getParameter($paramMatches[0]);
					}
				}

				if ($form)
				{
					$formHasData = ($form->data->where('data_id', $id, false)->count() > 0);

					if ($state == 'view')
					{
						$output = ($formHasData)
							? $form->present()->renderViewForm($id)
							: alert('danger', "No form data found.");

						return str_replace(["\r", "\n", "\t"], '', $output);
					}

					if ($state == 'edit')
					{
						$output = ($formHasData)
							? $form->present()->renderEditForm($id)
							: alert('danger', "No form data found.");

						return str_replace(["\r", "\n", "\t"], '', $output);
					}

					if ($state == 'new')
					{
						return str_replace(["\r", "\n", "\t"], '', $form->present()->renderNewForm());
					}
				}
				else
				{
					$alert = alert('warning', "No form found with the \"{$formKey}\" form key.");

					return str_replace(["\r", "\n", "\t"], '', $alert);
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
		return "__Forms__: Insert a form into any page by using the `{% form %}` tag. The form compiler accepts one,two or three parameters, depending on how you want to use it.

The first parameter is the form key of the form you want to display. (You can find the form key on the forms management page.) The second parameter is the state of the form. The possible states the form compiler accepts are: new, edit, and view. `{% form:my-awesome-form:create %}` If you do not pass a state to the compiler, it will default to the _create_ state. `{%  form:my-awesome-form %}`

The final parameter, and one tied to the state of the form, is a specific data ID you want to use for the edit and view states. You can pass a specific value to the compiler in order to show the edit or view state of your form `{% form:character:view:8 %}`. You can also pass a route parameter wrapped in braces if you want to dynamically grab what's in the URI. For example, if you created a route with a route parameter of ID (`form-test/{id}`) then you would be able to access that by using `{% form:my-awesome-form:view:{id} %}`. The compiler will grab that named route parameter and pull the value that's in the parameter and use it automatically.";
	}

}
