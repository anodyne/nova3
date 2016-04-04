{!! $formOpenTag !!}
	{!! partial('form-fields', ['fields' => $form->fieldsUnbound, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}

	{!! partial('form-sections', ['sections' => $form->sectionsUnbound, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}

	@if ($form->parentTabs->count() > 0)
		{!! partial('form-tabs-control', ['tabs' => $form->parentTabs, 'style' => 'tabs', 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}

		{!! partial('form-tabs-content', ['tabs' => $form->parentTabs, 'editable' => true, 'form' => $form, 'action' => $action, 'data' => $data, 'id' => $id]) !!}
	@endif

	@if ($includeButton)
		@php($buttonLabel = ($action == 'edit') ? "Update" : "Submit")
		<div class="form-group">
			<phone-tablet>
				<p>{!! Form::button($buttonLabel, ['class' => 'btn btn-primary btn-lg btn-block', 'type' => 'submit']) !!}</p>
			</phone-tablet>
			<desktop>
				<p>{!! Form::button($buttonLabel, ['class' => 'btn btn-primary btn-lg', 'type' => 'submit']) !!}</p>
			</desktop>
		</div>
	@endif
{!! $formCloseTag !!}