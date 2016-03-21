{!! $formOpenTag !!}
	{!! partial('form-fields', ['fields' => $form->fieldsUnbound, 'editable' => false, 'form' => $form, 'action' => $action]) !!}

	{!! partial('form-sections', ['sections' => $form->sectionsUnbound, 'editable' => false, 'form' => $form, 'action' => $action]) !!}

	@if ($form->parentTabs->count() > 0)
		{!! partial('form-tabs-control', ['tabs' => $form->parentTabs, 'style' => 'tabs', 'editable' => false, 'form' => $form, 'action' => $action]) !!}

		{!! partial('form-tabs-content', ['tabs' => $form->parentTabs, 'editable' => false, 'form' => $form, 'action' => $action]) !!}
	@endif
{!! $formCloseTag !!}