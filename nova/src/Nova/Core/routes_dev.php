<?php

Route::group(array('prefix' => 'dev'), function()
{
	Route::get('/', function()
	{
		$form = NovaForm::key('character')->first();

		// Get the form fields
		$formFields[0] = lang('short.selectOne', langConcat('form field'));
		$formFields+= $form->fields()->active()->orderAsc('label')->get()->toSimpleArray('id', 'label');

		$tab = $form->tabs()->find(2);

		$newField = $form->fields()->getModel()->newInstance([
			'form_id' => 4,
			'type' => 'text',
			'label' => 'Foo',
		])->save();

		//s($form);
		//s($formFields);
		//s($tab);
		//s($form->tabs->toSimpleArray('id', 'name'));
		s($newField);
	});
});