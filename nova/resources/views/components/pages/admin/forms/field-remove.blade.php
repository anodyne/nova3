<p>Are you sure you want to remove this field from the <em>{{ $form->present()->name }}</em> form?</p>

<p>Removing this field will also remove all field values and field data associated with this form field. This action is permanent and can't be undone!</p>

{!! Form::model($field, ['route' => ['admin.forms.fields.destroy', $form->key, $field->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<phone-tablet>
			<p>{!! Form::button("Remove Form Field", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</phone-tablet>
		<desktop>
			{!! Form::button("Remove Form Field", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}