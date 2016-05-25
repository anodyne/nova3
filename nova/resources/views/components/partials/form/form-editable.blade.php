{!! $formOpenTag !!}
	{!! partial('form/form-fields', ['fields' => $form->fieldsUnbound, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => $fieldNameWrapper]) !!}

	{!! partial('form/form-sections', ['sections' => $form->sectionsUnbound, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => $fieldNameWrapper]) !!}

	@if ($form->parentTabs->count() > 0)
		{!! partial('form/form-tabs-control', ['tabs' => $form->parentTabs, 'style' => 'tabs', 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}

		{!! partial('form/form-tabs-content', ['tabs' => $form->parentTabs, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id, 'fieldNameWrapper' => $fieldNameWrapper]) !!}
	@endif

	@if ($includeButton)
		@php($buttonLabel = ($action == 'edit') ? "Update" : "Submit")
		<div class="form-group" v-cloak>
			<mobile>
				<p>{!! Form::button($buttonLabel, ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</mobile>
			<desktop>
				<p>{!! Form::button($buttonLabel, ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}</p>
			</desktop>
		</div>
	@endif
{!! $formCloseTag !!}