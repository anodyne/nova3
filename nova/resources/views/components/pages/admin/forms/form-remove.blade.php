<p>Are you sure you want to remove the <strong>{{ $form->present()->name }}</strong> form? Removing this form will also remove all tabs, sections, fields, field values, and all data associated with this form. This action is permanent and can't be undone!</p>

{!! Form::model($form, ['route' => ['admin.forms.destroy', $form->key], 'method' => 'delete']) !!}
	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Remove Form", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</mobile>
		<desktop>
			{!! Form::button("Remove Form", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}