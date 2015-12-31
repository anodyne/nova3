<p>Are you sure you want to remove the <strong>{{ $section->present()->name }}</strong> section from the <em>{{ $form->present()->name }}</em> form?</p>

<p>Removing this section will also remove all fields, field values, and field data associated with this form section. This action is permanent and can't be undone!</p>

{!! Form::model($section, ['route' => ['admin.forms.sections.destroy', $form->key, $section->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<phone-tablet>
			<p>{!! Form::button("Remove Form Section", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</phone-tablet>
		<desktop>
			{!! Form::button("Remove Form Section", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}