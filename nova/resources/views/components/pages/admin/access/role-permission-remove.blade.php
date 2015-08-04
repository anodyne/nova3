<p>Are you sure you want to remove the <strong>{{ $permission->present()->displayName }}</strong> role permission? This action is permanent and can't be undone!</p>

{!! Form::model($permission, ['route' => ['admin.access.permissions.destroy', $permission->id], 'method' => 'delete']) !!}
	<div class="visible-xs visible-sm">
		<p>{!! Form::button("Remove Permission", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg btn-block']) !!}</p>
		<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
	</div>
	<div class="visible-md visible-lg">
		{!! Form::button("Remove Permission", ['type' => 'submit', 'class' => 'btn btn-danger btn-lg']) !!}
		{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
	</div>
{!! Form::close() !!}