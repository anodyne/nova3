{!! Form::open(['route' => ['admin.access.roles.copy', $role->id]]) !!}
	<div class="form-group">
		<label class="control-label">Original Role Name</label>
		<p>{{ $role->present()->displayName }}</p>
	</div>

	<div class="form-group">
		<label class="control-label">Original Role Key</label>
		<p>{{ $role->present()->key }}</p>
	</div>

	<div class="form-group">
		<label class="control-label">New Role Name</label>
		{!! Form::text('display_name', null, ['class' => 'form-control input-lg']) !!}
	</div>

	<div class="form-group">
		<label class="control-label">New Role Key</label>
		{!! Form::text('name', null, ['class' => 'form-control input-lg']) !!}
	</div>

	<div v-cloak>
		<mobile>
			<p>{!! Form::button("Duplicate Role", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg btn-block']) !!}</p>
			<p>{!! Form::button("Cancel", ['class' => 'btn btn-default btn-lg btn-block', 'data-dismiss' => 'modal']) !!}</p>
		</mobile>
		<desktop>
			{!! Form::button("Duplicate Role", ['type' => 'submit', 'class' => 'btn btn-primary btn-lg']) !!}
			{!! Form::button("Cancel", ['class' => 'btn btn-link-default btn-lg', 'data-dismiss' => 'modal']) !!}
		</desktop>
	</div>
{!! Form::close() !!}