<p>Are you sure you want to remove the <strong>{{ $tab->present()->name }}</strong> form tab? Removing this tab will also remove all sections, fields, field values, and field data associated with this form tab. This action is permanent and can't be undone!</p>

{!! Form::model($tab, ['route' => ['admin.forms.tabs.destroy', $form->key, $tab->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<phone-tablet>
			<p>{!! Form::button("Remove Form Tab", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</phone-tablet>
		<desktop>
			{!! Form::button("Remove Form Tab", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}