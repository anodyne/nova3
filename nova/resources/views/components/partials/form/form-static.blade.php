{!! $formOpenTag !!}
	{!! partial('form/form-fields', ['fields' => $form->fieldsUnbound, 'editable' => false, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => null]) !!}

	{!! partial('form/form-sections', ['sections' => $form->sectionsUnbound, 'editable' => false, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => null]) !!}

	@if ($form->parentTabs->count() > 0)
		{!! partial('form/form-tabs-control', ['tabs' => $form->parentTabs, 'style' => 'tabs', 'editable' => false, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}

		{!! partial('form/form-tabs-content', ['tabs' => $form->parentTabs, 'editable' => false, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => null]) !!}
	@endif
{!! $formCloseTag !!}