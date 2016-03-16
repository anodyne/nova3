{!! $formOpenTag !!}
	{!! partial('form-fields', ['fields' => $form->fieldsUnbound, 'editable' => true, 'form' => $form]) !!}

	{!! partial('form-sections', ['sections' => $form->sectionsUnbound, 'editable' => true, 'form' => $form]) !!}

	@if ($form->parentTabs->count() > 0)
		{!! partial('form-tabs-control', ['tabs' => $form->parentTabs, 'style' => 'tabs', 'editable' => true, 'form' => $form]) !!}

		{!! partial('form-tabs-content', ['tabs' => $form->parentTabs, 'editable' => true, 'form' => $form]) !!}
	@endif
{!! $formCloseTag !!}