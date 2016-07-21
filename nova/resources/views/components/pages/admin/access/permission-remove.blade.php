<p>Are you sure you want to remove the <strong>{{ $permission->present()->name }}</strong> permission? This action is permanent and can't be undone!</p>

{!! Form::model($permission, ['route' => ['admin.access.permissions.destroy', $permission->id], 'method' => 'delete']) !!}
	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Remove Permission", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</mobile>
		<desktop>
			{!! Form::button("Remove Permission", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}