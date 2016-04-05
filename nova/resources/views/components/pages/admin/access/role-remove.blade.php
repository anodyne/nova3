<p>Are you sure you want to remove the <strong>{{ $role->present()->displayName }}</strong> role? This action is permanent and can't be undone!</p>

{!! Form::model($role, ['route' => ['admin.access.roles.destroy', $role->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Remove Role", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</mobile>
		<desktop>
			{!! Form::button("Remove Role", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}