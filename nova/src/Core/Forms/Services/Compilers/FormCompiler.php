<?php namespace Nova\Core\Forms\Services\Compilers;

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
		$callback = function($matches)
		{
			// Get the values out of the tag
			$args = explode(':', $matches[2]);
			
			// Set the values
			$type = $args[0];
			$formKey = $args[1];
			$id = (array_key_exists(2, $args)) ? $args[2] : false;

			// Make sure we're only working with the right type
			if ($type == $this->identifier)
			{
				if ($matches[1]) return substr($matches[0], 1);

				// Get the form
				$form = app('FormRepository')->getByKey($formKey, null);

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
		return "__Forms__: Insert a form into any page by using the `{% form %}` tag. The tag accepts two or three parameters, depending on how you want to use it.";
	}

}
